<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Discussion extends Model
{
    public function topic() {
        return $this->belongsTo(Topic::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function replies(){
        return $this->hasMany(Reply::class);
    }

    public function bookmarks(){
        return $this->hasMany(DiscussionBookmark::class);
    }

    public function reports(){
        return $this->hasMany(DiscussionReport::class);
    }

}
