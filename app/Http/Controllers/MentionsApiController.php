<?php

namespace App\Http\Controllers;

use App\Models\Mention;
use App\Models\User;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MentionsApiController extends Controller
{
	public function search(Request $request)
	{
		$username = $request->input('username');

		return DB::table('users')
			->select('username AS value', 'username AS key')
			->get();

		//if ($username) {
			//return User::where('username', 'like', $username . '%')
			//	->limit(10)
			//	->orderBy('username', 'asc')
			//	->get();
		//}
    }

	public function store(Request $request)
	{
		$user = User::where('username', $request->input('username'))
			->first();

		Mention::create([
			'user_id' => $request->input('userId'),
			'user_id_mentioned' => $user->id,
			'reply_id' => $request->input('replyId')
		]);
	}
}
