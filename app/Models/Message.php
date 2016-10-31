<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
		'body'
	];

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function conversation()
	{
		return $this->belongsTo(Conversation::class);
	}

	public function author()
	{
		return $this->belongsTo(User::class, 'user_id');
	}
}
