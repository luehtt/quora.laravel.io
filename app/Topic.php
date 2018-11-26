<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    public function channel() {
        return $this->belongsTo(Channel::class);
    }

    public function discussions(){
        return $this->hasMany(Discussion::class);
    }
}
