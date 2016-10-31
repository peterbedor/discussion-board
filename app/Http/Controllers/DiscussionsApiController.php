<?php

namespace App\Http\Controllers;

use App\Models\Reply;
use App\Models\User;
use App\Models\Channel;
use App\Models\Discussion;
use Illuminate\Http\Request;
use App\Http\Requests;

class DiscussionsApiController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth');
	}
	
	public function show($channelSlug, $discussionSlug)
	{

		return Discussion::where('slug', $discussionSlug)
			->with([
				'mentions.user',
				'author',
				'replies.author',
				'replies.points',
				'replies.mentions.user'
			])->first();
    }

	public function index(Request $request)
	{
		$channel = Channel::where('slug', $request->input('channel'))
			->first();

		$discussions = Discussion::with([
			'channel',
			'author',
			'latestReply.author'
		]);

		if ($channel) {
			$discussions->where('channel_id', $channel->id);
		}

		return $discussions->orderBy('created_at', 'desc')->paginate(10);
	}

	public function create(Request $request)
	{
		$userId = $request->user()->id;

		$discussion = new Discussion();

		$mentions = $this->getMentions($request->input('body'));

		$discussion = $discussion->create([
			'title' => $request->input('title'),
			'body' => $request->input('body'),
			'channel_id' => $request->input('channel'),
			'user_id' => $userId,
			'slug' => $this->makeSlugFromTitle($request->input('title'))
		]);

		$this->saveMentions($mentions, $discussion, $userId);

		return $discussion->where('id', $discussion->id)->with('channel')->first();
	}

	// TODO: Extract this out into a service maybe
	public function makeSlugFromTitle($title)
	{
		$slug = str_slug($title);

		$count = Discussion::whereRaw("slug RLIKE '^{$slug}(-[0-9]+)?$'")->count();

		return $count ? "{$slug}-{$count}" : $slug;
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
