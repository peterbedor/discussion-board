<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Point extends Model
{
	public $timestamps = false;

    protected $fillable = [
		'user_id',
		'reply_id',
		'count'
	];

	/**
	 * @return $this
	 */
	public function user()
	{
		return $this->belongsToMany(Point::class, 'points')->withPivot('count');
	}
}
