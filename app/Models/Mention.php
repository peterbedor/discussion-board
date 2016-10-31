<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mention extends Model
{
	public $timestamps = false;

	protected $fillable = [
		'user_id',
		'reply_id',
		'user_id_mentioned'
	];

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function reply()
	{
		return $this->belongsTo(Reply::class);
    }

	public function discussion()
	{
		return $this->belongsTo(Discussion::class, 'item_id');
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function user()
	{
		return $this->belongsTo(User::class, 'user_id_mentioned');
	}
}
