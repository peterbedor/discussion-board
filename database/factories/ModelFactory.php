<?php

$factory->define(App\Models\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
		'username' => $faker->userName,
        'email' => $faker->unique()->safeEmail,
		'avatar' => $faker->imageUrl(100, 100),
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Models\Channel::class, function (Faker\Generator $faker) {
	$word = $faker->word . ' ' . $faker->word;

    return [
        'title' => $word,
		'slug' => str_slug($word),
		'color' => '#' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT)
    ];
});

$factory->define(App\Models\Discussion::class, function (Faker\Generator $faker) {
	$sentence = $faker->sentence;
	$user = App\Models\User::where('id', (rand(1, 30)))->first();
	$channel = App\Models\Channel::where('id', (rand(1, 15)))->first();

	return [
		'user_id' => $user->id,
		'channel_id' => $channel->id,
		'body' => implode($faker->paragraphs(3), '\n'),
		'title' => $sentence,
		'slug' => str_slug($sentence)
	];
});

$factory->define(App\Models\Discussion::class, function (Faker\Generator $faker) {
	$sentence = $faker->sentence;
	$user = App\Models\User::where('id', (rand(1, 30)))->first();
	$channel = App\Models\Channel::where('id', (rand(1, 15)))->first();

	return [
		'user_id' => $user->id,
		'channel_id' => $channel->id,
		'body' => implode($faker->paragraphs(3), '\n'),
		'title' => $sentence,
		'slug' => str_slug($sentence)
	];
});

$factory->define(App\Models\Reply::class, function (Faker\Generator $faker) {
	$user = App\Models\User::where('id', (rand(1, 30)))->first();
	$discussion = App\Models\Discussion::where('id', (rand(1, 200)))->first();

	return [
		'user_id' => $user->id,
		'discussion_id' => $discussion->id,
		'body' => implode($faker->paragraphs(3), '\n')
	];
});

$factory->define(App\Models\Point::class, function (Faker\Generator $faker) {
	$user = App\Models\User::where('id', (rand(1, 30)))->first();
	$reply = App\Models\Reply::where('id', (rand(1, 200)))->first();

	return [
		'user_id' => $user->id,
		'reply_id' => $reply->id,
		'count' => rand(1, 321)
	];
});

$factory->define(App\Models\Conversation::class, function (Faker\Generator $faker) {
	$user = App\Models\User::where('id', (rand(1, 30)))->first();

	return [
		'user_id' => $user->id
	];
});

$factory->define(App\Models\Message::class, function (Faker\Generator $faker) {
	$to = App\Models\User::find(5);
	$from = App\Models\User::find(3);
	$conversation = App\Models\Conversation::where('id', (rand(1, 200)))->first();

	return [
		'user_id' => $from->id,
		'recipient_id' => $to->id,
		'conversation_id' => 3,
		'body' => $faker->paragraph
	];
});

$factory->define(App\Models\UserData::class, function (Faker\Generator $faker) {
	$user = \App\Models\User::find(rand(1, 30));

	return [
		'user_id' => $user->id,
		'about' => $faker->paragraph,
		'twitter' => $faker->word,
		'linked_in' => $faker->word,
		'github' => $faker->word,
		'bitbucket' => $faker->word,
		'birthday' => $faker->dateTime
	];
});