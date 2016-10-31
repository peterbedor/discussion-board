<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Discussion extends Model
{
	protected $fillable = [
		'user_id',
		'channel_id',
		'title',
		'slug',
		'body',
		'active'
	];

	protected $appends = [
		'human_created_at',
		'human_updated_at'
	];

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function replies()
	{
		return $this->hasMany(Reply::class);
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function user()
	{
		return $this->belongsTo(User::class);
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function author()
	{
		return $this->belongsTo(User::class, 'user_id');
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function channel()
	{
		return $this->belongsTo(Channel::class);
	}

	/**
	 * Retrieve latest related reply
	 *
	 * @return mixed
	 */
	public function latestReply()
	{
		return $this->hasOne(Reply::class)->latest();
	}

	public function mentions()
	{
		return $this->hasMany(Mention::class, 'item_id');
	}

	public function getHumanCreatedAtAttribute()
	{
		return Carbon::createFromFormat('Y-m-d G:i:s', $this->created_at)
			->diffForHumans();
	}

	public function getHumanUpdatedAtAttribute()
	{
		return Carbon::createFromFormat('Y-m-d G:i:s', $this->updated_at)
			->diffForHumans();
	}
}
