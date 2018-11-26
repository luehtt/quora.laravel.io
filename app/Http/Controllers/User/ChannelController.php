<?php

namespace App\Http\Controllers\User;

use App\Channel;
use App\Discussion;
use App\Http\Controllers\Controller;
use App\Topic;
use App\TopicBookmark;
use App\User;
use Exception;
use Illuminate\Http\Request;

class ChannelController extends Controller
{
    public function index()
    {
        $items = Channel::orderBy('id')->with('topics')->get();
        foreach ($items as $c) {
            $t = $c->topics->pluck('id');
            $d = Discussion::whereIn('topic_id', $t)->orderBy('updated_at', 'desc')->with('user')->take(5)->get();
            $c->discussions = $d;
        }
        return view('user.channel.index')->with(['items' => $items]);
    }

    public function channel($slug)
    {
        $channel = Channel::where('slug', $slug)->first();
        if (!$channel) return redirect('/home');
        $topics = Topic::where('channel_id', $channel->id)->orderBy('id')->get();
        $ids = $topics->pluck('id');
        $items = Discussion::whereIn('topic_id', $ids)->orderBy('updated_at', 'desc')->with('user')->paginate(10);
        return view('user.channel.show')->with(['items' => $items, 'channel' => $channel, 'topics' => $topics]);
    }

    public function topic(Request $request, $slug)
    {
        $topic = Topic::where('slug', $slug)->withCount('discussions')->first();
        if (!$topic) return redirect('/home');
        $channel = Channel::find($topic->channel_id);

        // get order
        $order = $request->has('order') ? $request->input('order') : 'updated_at';
        switch ($order) {
            case "replies": $items = Discussion::where('topic_id', $topic->id)->withCount('replies')->orderBy('replies_count', 'desc')->with('user')->paginate(10); break;
            case "bookmarks": $items = Discussion::where('topic_id', $topic->id)->withCount('bookmarks')->orderBy('bookmarks_count', 'desc')->with('user')->paginate(10); break;
            case "views": $items = Discussion::where('topic_id', $topic->id)->orderBy('views', 'desc')->with('user')->paginate(10); break;
            case "updated_at": $items = Discussion::where('topic_id', $topic->id)->orderBy('updated_at', 'desc')->with('user')->paginate(10); break;
            case "created_at": $items = Discussion::where('topic_id', $topic->id)->orderBy('created_at', 'desc')->with('user')->paginate(10); break;
            default: $items = Discussion::where('topic_id', $topic->id)->orderBy('id')->with('user')->paginate(10);
        }

        // get if user bookmarked this topic
        $user = auth()->user();
        if ($user) {
            $bookmarked = TopicBookmark::where('topic_id', $topic->id)->where('user_id', $user->id)->first();
            if($bookmarked) $topic->bookmarked = true;
        }
        return view('user.channel.show')->with(['items' => $items, 'channel' => $channel, 'topic' => $topic]);
    }

    public function bookmark($id) {
        try {
            $topic = Topic::find($id);
            $user = auth()->user();
            if (!$topic) return redirect('/home')->with(['message' => 'Data not found', 'success' => false]);
            $bookmark = TopicBookmark::where('topic_id', $id)->where('user_id', $user->id)->first();

            // in case $item exists -> delete
            if ($bookmark) $bookmark->delete();
            else {
                $item = new TopicBookmark();
                $item->user_id = $user->id;
                $item->topic_id = $id;
                $item->save();
            }
            return redirect('/channel/topic/'.$topic->slug);
        } catch (Exception $exception){
            return redirect('/home')->with(['message' => $exception->getMessage(), 'success' => false]);
        }
    }
}
