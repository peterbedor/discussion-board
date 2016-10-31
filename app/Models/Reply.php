<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    protected $fillable = [
		'user_id',
		'discussion_id',
		'body',
		'active'
	];

	protected $appends = [
		'human_created_at',
		'human_updated_at'
	];

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasOne
	 */
	public function points()
	{
		return $this->hasOne(Point::class);
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
	public function discussion()
	{
		return $this->belongsTo(Discussion::class);
	}

	/**
	 * Increment points column
	 *
	 * @param int $points
	 * @return mixed
	 */
	public function addPoints($points = 1)
	{
		return $this->points()->increment('points', $points);
	}

	/**
	 * Decrement points column
	 *
	 * @param int $points
	 * @return mixed
	 */
	public function removePoints($points = 1)
	{
		return $this->points()->decrement('points', $points);
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
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
