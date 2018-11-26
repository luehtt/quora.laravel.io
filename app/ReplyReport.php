<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReplyReport extends Model
{
    public function user() {
        return $this->belongsTo(User::class);
    }

    public function reply() {
        return $this->belongsTo(Reply::class);
    }

    public function reason() {
        return $this->belongsTo(ReportReason::class, 'report_reason_id', 'id');
    }
}
