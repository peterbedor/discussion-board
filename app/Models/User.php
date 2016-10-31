<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
		'last_name',
		'username',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
		'remember_token',
		'email'
    ];

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function discussions()
	{
		return $this->hasMany(Discussion::class);
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function replies()
	{
		return $this->hasMany(Reply::class);
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function points()
	{
		return $this->hasMany(Point::class);
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function messages()
	{
		return $this->hasMany(Message::class, 'user_id');
	}

	public function mentions()
	{
		return $this->hasMany(Mention::class);
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function messageReplies()
	{
		return $this->hasMany(Message::class, 'recipient_id');
	}

	/**
	 * Retrieve sum of all user points
	 *
	 * @return int
	 */
	public function allPoints()
	{
		return (int) $this->points()->sum('points');
	}

	public function data()
	{
		return $this->hasOne(UserData::class);
	}
}
