<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
    protected $fillable = [
		'title',
		'slug',
		'color',
		'active'
	];

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function discussions()
	{
		return $this->hasMany(Discussion::class);
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
	 */
	public function replies()
	{
		return $this->hasManyThrough(Reply::class, Discussion::class);
	}

	/**
	 * Retrieve latest related discussion
	 *
	 * @return mixed
	 */
	public function latestDiscussion()
	{
		return $this->hasOne(Discussion::class)->latest();
	}
}
