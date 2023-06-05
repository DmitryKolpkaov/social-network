<?php

namespace App\Models\Friends;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;


class Friends extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    public function friendsOfMine()
    {
        return $this->belongsToMany('App\Models\User', 'friends', 'user_id', 'friend_id');
    }

    public function friendOf()
    {
        return $this->belongsToMany('App\Models\User', 'friends', 'friend_id', 'user_id');
    }

    public function friends()
    {
        return $this->friendsOfMine()
            ->wherePivot('accepted', true)
            ->get()
            ->merge($this->friendOf()
                ->wherePivot('accepted', true)
                ->get());
    }
}
