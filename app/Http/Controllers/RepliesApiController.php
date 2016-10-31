<?php

namespace App\Http\Controllers;

use App\Models\Point;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Reply;
use App\Models\User;

class RepliesApiController extends Controller
{
	public function store(Request $request)
	{
		$userId = $request->user()->id;

		$reply = Reply::create([
			'discussion_id' => $request->input('discussion_id'),
			'user_id' => $userId,
			'body' => $request->input('reply')
		]);

		$mentions = $this->getMentions($request->input('reply'));

		$this->saveMentions($mentions, $reply, $userId);

		Point::create([
			'user_id' => $userId,
			'reply_id' => $reply->id
		]);

		return $reply->where('id', $reply->id)
			->with('author', 'mentions.user', 'points')
			->first();
    }

	public function getMentions($body)
	{
		preg_match_all('/\B@[a-z0-9._-]+/', $body, $out);

		$returnArr = array_map('array_unique', $out);

		if (count($returnArr)) {
			return collect($returnArr[0])->map(function($mention) {
				return ltrim($mention, '@');
			});
		}

		return false;
	}

	public function saveMentions($mentions, $message, $userId)
	{
		$mentions->each(function($mention) use ($message, $userId) {
			$user = User::where('username', $mention)->first();

			if ($user) {
				$message->mentions()->create([
					'user_id' => $userId,
					'user_id_mentioned' => $user->id
				]);
			}
		});
	}
}
