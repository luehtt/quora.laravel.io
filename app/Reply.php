<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    public function user() {
        return $this->belongsTo(User::class);
    }

    public function discussion() {
        return $this->belongsTo(Discussion::class);
    }

    public function upvotes(){
        return $this->hasMany(ReplyUpvote::class, '');
    }

    public function downvotes(){
        return $this->hasMany(ReplyDownvote::class);
    }

    public function reports(){
        return $this->hasMany(ReplyReport::class);
    }
}
