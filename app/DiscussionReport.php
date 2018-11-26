<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DiscussionReport extends Model
{
    public function user() {
        return $this->belongsTo(User::class);
    }

    public function discussion() {
        return $this->belongsTo(Discussion::class);
    }

    public function reason() {
        return $this->belongsTo(ReportReason::class, 'report_reason_id', 'id');
    }
}
