<?php

namespace App\Http\Controllers;

use App\Models\Channel;
use App\Http\Requests;
use App\Models\Discussion;
use Illuminate\Http\Request;

class ChannelsApiController extends Controller
{
	public function index()
	{
		return Channel::withCount([
				'discussions',
				'replies'
			])->with([
				'latestDiscussion.author'
			])->get();
    }

	public function show($slug)
	{
		$channel = Channel::where('slug', $slug)->first();

		return Discussion::where('channel_id', $channel->id)
			->withCount('replies')
			->with([
				'channel',
				'author',
				'latestReply'
			])->paginate(10);
	}
}
