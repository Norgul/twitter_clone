<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tweet extends Model
{
    protected $fillable = [
        'twitter_id', 'text', 'user_id'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
