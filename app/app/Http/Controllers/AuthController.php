<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function getSignup()
    {
        return view('auth.signup');
    }

    public function postSignup(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|unique:users|email|max:255',
            'username' => 'required|unique:users|alpha_dash|max:20',
            'password' => 'required|min:8'
        ]);

        User::create([
            'email' => $request->input('email'),
            'username' => $request->input('username'),
            'password' => bcrypt($request->input('password'))
        ]);

        return redirect()
            ->route('home')
            ->with('info', 'Регистрация прошла успешно!');
    }

    public function getSignin()
    {
        return view('auth.signin');
    }

    public function postSignin(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|max:255',
            'password' => 'required|min:8'
        ]);

        if(!Auth::attempt($request->only(['email', 'password']),$request->has('remember'))){
            return redirect()
                ->back()
                ->with('info', 'Неправильно указан email или пароль.');
        }
        return redirect()
            ->route('home')
            ->with('info', 'Авторизация прошла успешно.');
    }

    public function getSignout()
    {
        Auth::logout();

        return redirect()->route('home');
    }
}
