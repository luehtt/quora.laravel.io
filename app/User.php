<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'user_role_id', 'photo'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'email_verified_at', 'user_role_id', 'created_at', 'updated_at'
    ];

    public function user_role() {
        return $this->belongsTo(UserRole::class);
    }


    public function isAdmin() {
        return $this->user_role_id == UserRole::findByName("ADMIN")->id;
    }

    public function isManager() {
        return $this->user_role_id == UserRole::findByName("MODERATOR")->id
            || $this->user_role_id == UserRole::findByName("ADMIN")->id;
    }

    public function bookmarked() {
        return $this->belongsToMany(Discussion::class, 'discussion_bookmarks', 'user_id', 'discussion_id');
    }

    public function discussions() {
        return $this->hasMany(Discussion::class);
    }

    public function replies() {
        return $this->hasMany(Reply::class);
    }

    public function discussion_reports() {
        return $this->hasMany(DiscussionReport::class);
    }

    public function reply_reports() {
        return $this->hasMany(ReplyReport::class);
    }

    public function reply_upvotes() {
        return $this->hasMany(ReplyUpvote::class);
    }

    public function reply_downvotes() {
        return $this->hasMany(ReplyDownvote::class);
    }

    public static function bookmarkedDiscussions() {
        // can use belongsToMany since there is no duplicate
        // return $this->belongsToMany(Discussion::class, 'discussion_bookmarks', 'user_id', 'discussion_id');
        $user = auth()->user();
        $replies = DiscussionBookmark::where('user_id', $user->id)->get();
        $ids = $replies->pluck('discussion_id')->unique();
        return Discussion::whereIn('id', $ids)->orderBy('updated_at', 'desc')->with('user')->with('topic')->paginate(10);
    }

    public static function postedDiscussions() {
        $user = auth()->user();
        return Discussion::where('user_id', $user->id)->orderBy('updated_at', 'desc')->with('user')->with('topic')->paginate(10);
    }

    public static function repliedDiscussions() {
        // do not use belongsToMany since it would give duplicate discussion
        // return $this->belongsToMany(Discussion::class, 'replies', 'user_id', 'discussion_id');
        $user = auth()->user();
        $replies = Reply::where('user_id', $user->id)->get();
        $ids = $replies->pluck('discussion_id')->unique();
        return Discussion::whereIn('id', $ids)->orderBy('updated_at', 'desc')->with('user')->with('topic')->paginate(10);
    }

    public static function reportedDiscussions() {
        // do not use belongsToMany since it would give duplicate discussion
        // return $this->belongsToMany(Discussion::class, 'discussion_reports', 'user_id', 'discussion_id');
        $user = auth()->user();
        $replies = DiscussionReport::where('user_id', $user->id)->get();
        $ids = $replies->pluck('discussion_id')->unique();
        return Discussion::whereIn('id', $ids)->orderBy('updated_at', 'desc')->with('user')->with('topic')->paginate(10);
    }
}
