<?php

namespace App\Http\Controllers;

use App\Models\Point;
use App\Models\Reply;
use App\Models\User;
use Illuminate\Http\Request;

use App\Http\Requests;

class PointsApiController extends Controller
{
	public function increment(Request $request, Reply $reply, $replyId)
	{
		$reply->find($replyId)->addPoints();

		return Point::where('reply_id', $replyId)->get();
    }

	public function decrement(Request $request, Reply $reply, $replyId)
	{
		$reply->find($replyId)->removePoints();
	}
}
