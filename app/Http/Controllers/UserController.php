<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Mockery\Exception;
use function MongoDB\BSON\toJSON;
//use Thujohn\Twitter\Twitter;

use Thujohn\Twitter\Facades\Twitter;
use App\Tweet;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('index', compact('users'));
    }

    public function store($username)
    {
        try {
            $user = Twitter::getUsersLookup(['screen_name' => $username])[0];
        } catch (\RuntimeException $e) {
            return 'No such user';
        }

        if (User::where('twitter_id', $user->id)->exists())
            return redirect('/');

        User::create([
            'twitter_id'  => $user->id,
            'name'        => $user->name,
            'screen_name' => $user->screen_name
        ]);

        return redirect('/');
    }

    public function show(User $user)
    {
        $tweets = Twitter::getUserTimeline(['user_id' => $user->twitter_id, 'count' => config('twitter.TWEET_LIMIT')]);

        foreach ($tweets as $tweet) {
            if (!Tweet::where('twitter_id', $tweet->id)->exists())
                Tweet::create(['twitter_id' => $tweet->id, 'text' => $tweet->text, 'user_id' => $user->id]);
        }

        return view('users.show', compact('user', 'tweets'));
    }
}
