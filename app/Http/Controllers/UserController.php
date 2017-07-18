<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
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

    public function search()
    {
        $users = User::pluck('name', 'id')->prepend('Pick a user', 0);
        return view('search', compact('users'));
    }

    public function query(Request $request)
    {
        Session::put(['request' => $request->all()]);
        return redirect('search/results');
    }

    public function results()
    {
        $request = Session::get('request');
        $text = $request['text'];

        $tweets = Tweet::whereRaw("MATCH (twitter_id, text) AGAINST ('$text')");

        if ($request['user_id'] != 0)
            $tweets = $tweets->where('user_id', $request['user_id']);

        if (count($tweets) == 0)
            return 'No tweets found by given query';

        $tweets = $tweets->paginate(config('twitter.PAGINATE_LIMIT'));

        return view('search_results', compact('tweets'));
    }


}
