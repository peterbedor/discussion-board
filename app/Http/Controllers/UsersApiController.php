<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;

class UsersApiController extends Controller
{
	public function user(Request $request)
	{
		return Auth::user();
	}
	public function show($userName)
	{
		$user = User::where('username', ltrim($userName, '@'))
			->with('data')
			->first();

		$user->points = $user->allPoints();

		return $user;
    }
}
