<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use Illuminate\Http\Request;

use App\Http\Requests;

class ConversationsApiController extends Controller
{
	public function show(Request $request, $id)
	{
		return Conversation::find($id)
			->with([
				'messages',
				'messages.author'
			])->get();
    }
}
