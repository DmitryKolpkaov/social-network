<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'email',
        'username',
        'password',
        'first_name',
        'last_name',
        'location',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Получаем имя и фамилию или только имя
     *
     * @return mixed|string|null
     */
    public function getName()
    {
        if($this->first_name && $this->last_name){
            return "{$this->first_name} {$this->last_name}";
        }

        if($this->first_name){
            return $this->first_name;
        }

        return null;
    }

    /**
     * Получаем имя и фамилию или логин
     *
     * @return mixed|string
     */
    public function getNameOrUsername()
    {
        return $this->getName() ? : $this->username;
    }

    /**
     * Получаем имя пользователя или логин
     *
     * @return mixed
     */
    public function getFirstNameOrUsername()
    {
        return $this->first_name ? : $this->username;
    }

    /**
     * Получаем аватар из gravatar
     *
     * @return string
     */
    public function getAvatarUrl()
    {
        return "https://www.gravatar.com/avatar/{{md5($this->email)?d=wavatar&s=60}}";
    }

    //Друзья

    /**
     * Мои друзья
     *
     * @return BelongsToMany
     */
    public function friendsOfMine()
    {
        return $this->belongsToMany('App\Models\User', 'friends', 'user_id', 'friend_id');
    }

    /**
     * Мой Друг
     *
     * @return BelongsToMany
     */
    public function friendOf()
    {
        return $this->belongsToMany('App\Models\User', 'friends', 'friend_id', 'user_id');
    }

    /**
     * Получаем друзей, которые приняли заявку
     *
     * @return Collection
     */
    public function friends()
    {
        return $this->friendsOfMine()
            ->wherePivot('accepted', true)
            ->get()
            ->merge($this->friendOf()
                ->wherePivot('accepted', true)
                ->get());
    }

    /**
     * Заявка на добавление в друзья
     *
     * @return Collection
     */
    public function friendRequests()
    {
        return $this->friendsOfMine()
            ->wherePivot('accepted', false)
            ->get();
    }


    /**
     * Запрос на ожидание друга
     *
     * @return Collection
     */
    public function friendRequestPending()
    {
        return $this->friendOf()
            ->wherePivot('accepted', false)
            ->get();
    }


    /**
     * Есть запрос на добавление в друзья
     *
     * @param User $user
     * @return bool
     */
    public function hasFriendRequestPending(User $user)
    {
         return (bool) $this->friendRequestPending()
             ->where('id', $user->id)
             ->count();
    }

    /**
     * Получил запрос о дружбе
     *
     * @param User $user
     * @return bool
     */
    public function hasFriendRequestReceived(User $user)
    {
        return (bool) $this->friendRequests()
            ->where('id', $user->id)
            ->count();
    }

    /**
     * Добавить друга
     *
     * @param User $user
     * @return void
     */
    public function addFriend(User $user)
    {
        $this->friendOf()->attach($user->id);
    }

    /**
     * Удалить друга
     *
     * @param User $user
     * @return void
     */
    public function deleteFriend(User $user)
    {
        $this->friendOf()->detach($user->id);
        $this->friendsOfMine()->detach($user->id);
    }

    /**
     * Принять запрос на дружбу
     *
     * @param User $user
     * @return void
     */
    public function acceptFriendRequest(User $user)
    {
        $this->friendRequests()->where('id', $user->id)->first()->pivot->update([
           'accepted'=> true
        ]);
    }

    /**
     * Пользователь уже в друзьях
     *
     * @param User $user
     * @return bool
     */
    public function isFriendWith(User $user)
    {
        return (bool) $this->friends()
            ->where('id', $user->id)
            ->count();
    }
}
