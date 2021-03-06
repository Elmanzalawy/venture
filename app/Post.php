<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'title',
        'link',
        'text',
        'image',
        'subreddit_id'
    ];

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function votes() {
        return $this->hasMany('App\Vote');
    }
}
