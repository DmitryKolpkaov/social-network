<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Status;

class HomeController extends Controller
{
    public function index()
    {
        if(Auth::check()){
            $statuses = Status::notReply()->where(function($query){
               return $query->where('user_id', Auth::user()->id)
                   ->orWhereIn('user_id', Auth::user()->friends()->pluck('id'));
            })->orderBy('created_at', 'desc')->paginate(10);

            return view('timeline.index', compact('statuses'));
        }

        return view('home');
    }
}
