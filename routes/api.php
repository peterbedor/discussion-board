<?php

use Illuminate\Http\Request;

Route::get('user', 'UsersApiController@user');

Route::get('channel', 'ChannelsApiController@index');

Route::get('channel/{slug}', 'ChannelsApiController@show');

Route::get('channel/{channelSlug}/{discussionSlug}', 'DiscussionsApiController@show');
Route::post('channel/{channelSlug}/{discussionSlug}', 'RepliesApiController@store');

Route::get('discussion', 'DiscussionsApiController@index');
Route::post('discussion/create', 'DiscussionsApiController@create');

Route::get('points/{replyId}/up', 'PointsApiController@increment');
Route::get('points/{replyId}/down', 'PointsApiController@decrement');

Route::get('conversation/{id}', 'ConversationsApiController@show');

Route::get('mention', 'MentionsApiController@search');

Route::post('mention', 'MentionsApiController@store ');

Route::get('/user/{userName}', 'UsersApiController@show');
