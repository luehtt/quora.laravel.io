<?php

namespace App\Http\Controllers\User;

use App\Channel;
use App\Discussion;
use App\DiscussionBookmark;
use App\DiscussionReport;
use App\Http\Controllers\Controller;
use App\Reply;
use App\ReplyDownvote;
use App\ReplyReport;
use App\ReplyUpvote;
use App\ReportReason;
use App\Topic;
use Exception;
use Illuminate\Http\Request;

class DiscussionController extends Controller
{
    private $user;
    private $report_reasons;
    private $channel;
    private $topic;
    private $related_topics;
    private $item;

    function findOnId($id) {
        if ($this->item && $id == $this->item->id) return;
        $this->item = Discussion::where('id', $id)->with('user')->with('bookmarks')->with('reports')->first();
        if (!$this->item) throw new Exception('Data not found');
        $this->findRelations();
    }

    function findOnSlug($slug) {
        if ($this->item && $slug == $this->item->slug) return;
        $this->item = Discussion::where('slug', $slug)->with('user')->with('bookmarks')->with('reports')->first();
        if (!$this->item) throw new Exception('Data not found');
        $this->findRelations();
    }

    function findRelations() {
        $this->user = auth()->user();
        $this->report_reasons = ReportReason::orderBy('id')->get();
        $this->topic = Topic::find($this->item->topic_id);
        $this->channel = Channel::find($this->topic->channel_id);
        $this->related_topics = Topic::where('channel_id', $this->channel->id);
    }

    function redirectOnError($exception) {
        if ($this->item) return redirect('/discussion/'.$this->item->slug)->with(['message' => $exception->getMessage(), 'success' => false]);
        else return redirect('/home')->with(['message' => $exception->getMessage(), 'success' => false]);
    }

    function redirectReportOnError($exception) {
        if ($this->item) return redirect('/discussion/'.$this->item->slug.'/report')->with(['message' => $exception->getMessage(), 'success' => false]);
        else return redirect('/home')->with(['message' => $exception->getMessage(), 'success' => false]);
    }

    function redirect() {
        if ($this->item) return redirect('/discussion/'.$this->item->slug);
        else return redirect('/home')->with(['message' => 'Debug error!?', 'success' => false]);
    }

    function redirectReport() {
        if ($this->item) return redirect('/discussion/'.$this->item->slug.'/report');
        else return redirect('/home')->with(['message' => 'Debug error!?', 'success' => false]);
    }

    function ifUnauthorized() {
        if (!$this->item) throw new Exception('Data not found');
        if (!$this->user) throw new Exception('User not found');
        if ($this->item->user_id != $this->user->id) {
            if ($this->item->user->isManager()) throw new Exception('Unauthorized access');
            if (!$this->user->isManager()) throw new Exception('Unauthorized access');
        }
    }

    function ifSelfReport() {
        if ($this->item->user_id == $this->user->id) throw new Exception('Unauthorized access');
    }

    function ifUnarchived() {
        if ($this->item->archived == true) throw new Exception('Unauthorized access');
    }

    public function create($slug)
    {
        $topics = Topic::where('slug', $slug);
        $channel = Channel::find($topics->first()->channel_id);
        return view('user.discuss.create')->with(['topic' => $topics->first(), 'topics' => $topics, 'channel' => $channel]);
    }

    public function show($slug)
    {
        try {
            $this->findOnSlug($slug);
            $this->item->timestamps = false;
            $this->item->views = $this->item->views + 1;
            $this->item->save();

            // the owner can archive and delete
            // the other can bookmark and report
            // the manager can do both

            // owner case + manager case
            if ($this->item->user_id == $this->user->id || ($this->user->isManager() && !$this->item->user->isManager())) {
                $this->item->manageable = true;
            }

            // other case + manager case
            if ($this->item->user_id != $this->user->id) {
                $this->item->bookmarkable = true;
                $bookmarked = DiscussionBookmark::where('user_id', $this->user->id)->where('discussion_id', $this->item->id)->first();
                if ($bookmarked) $this->item->bookmarked = true;
                $reported = DiscussionReport::where('user_id', $this->user->id)->where('discussion_id', $this->item->id)->first();
                if ($reported) $this->item->reported = true;
            }

            // get replies and their down-votes or up-votes belong to each user
            $replies = Reply::where('discussion_id', $this->item->id)->with('user')->with('reports')->with('upvotes')->with('downvotes')->orderBy('updated_at', 'desc')->paginate(10);
            foreach ($replies as $i) {
                if (ReplyUpvote::where('reply_id', $i->id)->where('user_id', $this->user->id)->first()) $i->upvoted = "true";
                if (ReplyDownvote::where('reply_id', $i->id)->where('user_id', $this->user->id)->first()) $i->downvoted = true;
                if (ReplyReport::where('reply_id', $i->id)->where('user_id', $this->user->id)->first()) $i->reported = true;
                if ($i->user_id == $this->user->id || $this->user->isManager()) $i->deleteable = true;
            }

            return view('user.discuss.show')->with(['item' => $this->item, 'topic' => $this->topic, 'channel' => $this->channel, 'replies' => $replies, 'user' => $this->user]);
        } catch(Exception $exception) {
            return $this->redirectOnError($exception);
        }
    }

    public function store(Request $request)
    {
        try {
            $item = new Discussion();
            $item->title = $request->input('title');
            $item->content = $request->input('content');
            $item->topic_id = $request->input('topic_id');
            $item->slug = str_slug($item->title);
            $item->user_id = auth()->user()->id;
            $item->save();
            $this->findOnId($item->id);
            return $this->redirect();
        } catch(Exception $exception) {
            return $this->redirectOnError($exception);
        }
    }

    public function edit($slug)
    {
        $this->findOnSlug($slug);
        $topics = Topic::where('id', $this->topic->id);
        return view('user.discuss.edit')->with(['item' => $this->item, 'topics' => $topics]);
    }

    public function update(Request $request, $id)
    {
        try {
            $this->findOnId($id);
            $this->ifUnauthorized();
            if ($request->has('title')) $this->item->title = $request->input('title');
            if ($request->has('title')) $this->item->slug = str_slug($this->item->title);
            if ($request->has('content')) $this->item->content = $request->input('content');
            if ($request->has('topic_id')) $this->item->topic_id = $request->input('topic_id');
            $this->item->save();
            return $this->redirect();
        } catch(Exception $exception) {
            return $this->redirectOnError($exception);
        }
    }

    public function close($slug)
    {
        try {
            $this->findOnSlug($slug);
            $this->ifUnauthorized();
            return view('user.discuss.close')->with(['user_id' => $this->user->id, 'item' => $this->item]);
        } catch (Exception $exception) {
            return $this->redirectOnError($exception);
        }
    }

    public function archive($id)
    {
        try {
            $this->findOnId($id);
            $this->ifUnauthorized();
            $this->item->archived = true;
            $this->item->save();
            return $this->redirect();
        } catch (Exception $exception) {
            return $this->redirectOnError($exception);
        }
    }

    public function investigate($slug)
    {
        try {
            $this->findOnSlug($slug);
            if ($this->item->user_id == $this->user->id) $this->item->reportable = true;
            $reports = DiscussionReport::where('discussion_id', $this->item->id)->with('user')->with('reason')->orderBy('updated_at', 'desc')->get();
            return view('user.discuss.report')->with(['item' => $this->item, 'reports' => $reports, 'topic' => $this->topic, 'channel' => $this->channel, 'reasons' => $this->report_reasons]);
        } catch(Exception $exception) {
            return $this->redirectOnError($exception);
        }
    }

    public function report(Request $request, $id)
    {
        try {
            $this->findOnId($id);
            $this->ifSelfReport();
            $get = DiscussionReport::where('user_id', $this->user->id)->where('discussion_id', $this->item->id)->first();
            if ($get) {
                if ($request->has('content')) $get->content = $request->input('content');
                if ($request->has('report_reason_id')) $get->report_reason_id = $request->input('report_reason_id');
                $get->save();
            } else {
                $item = new DiscussionReport();
                $item->user_id = $this->user->id;
                $item->discussion_id = $this->item->id;
                $item->content = $request->input('content');
                $item->report_reason_id = $request->input('report_reason_id');
                $item->save();
            }
            return $this->redirectReport();
        } catch (Exception $exception){
            return $this->redirectReportOnError($exception);
        }
    }

    public function bookmark($id)
    {
        try {
            $this->findOnId($id);
            $bookmark = DiscussionBookmark::where('user_id', $this->user->id)->where('discussion_id', $this->item->id)->first();

            // in case $bookmark exists -> delete
            if ($bookmark) $bookmark->delete();
            else {
                $item = new DiscussionBookmark();
                $item->user_id = $this->user->id;
                $item->discussion_id = $this->item->id;
                $item->save();
            }
            return $this->redirect();
        } catch (Exception $exception){
            return $this->redirectOnError($exception);
        }
    }

    public function reply(Request $request, $id)
    {
        try {
            $this->findOnId($id);
            $this->ifUnarchived();

            $item = new Reply();
            $item->discussion_id = $this->item->id;
            $item->user_id = $this->user->id;
            $item->content = $request->input('content');
            $item->save();

            // update update_at of discussion
            $this->item->updated_at = now()->timestamp;
            $this->item->timestamps = true;
            $this->item->save();
            return $this->redirect();
        } catch (Exception $exception){
            return $this->redirectOnError($exception);
        }
    }

    public function delete($slug)
    {
        try {
            $this->findOnSlug($slug);
            $this->ifUnauthorized();
            return view('user.discuss.delete')->with(['user_id' => $this->user->id, 'item' => $this->item]);
        } catch (Exception $exception) {
            return $this->redirectOnError($exception);
        }
    }

    public function destroy($id)
    {
        try {
            $this->findOnId($id);
            $this->ifUnauthorized();

            DiscussionBookmark::where('discussion_id', $this->item->id)->delete();
            DiscussionReport::where('discussion_id', $this->item->id)->delete();


            $replies = Reply::where('discussion_id', $this->item->id)->get();
            foreach ($replies as $i) {
                ReplyUpvote::where('reply_id', $i->id)->delete();
                ReplyDownvote::where('reply_id', $i->id)->delete();
                ReplyReport::where('reply_id', $i->id)->delete();
            }
            Reply::where('discussion_id', $this->item->id)->delete();

            $this->item->delete();
            return redirect('/channel/topic/'.$this->topic->id);
        } catch (Exception $exception) {
            return $this->redirectOnError($exception);
        }
    }
}
