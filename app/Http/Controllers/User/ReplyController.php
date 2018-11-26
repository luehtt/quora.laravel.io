<?php

namespace App\Http\Controllers\User;

use App\Discussion;
use App\Reply;
use App\ReplyDownvote;
use App\ReplyReport;
use App\ReplyUpvote;
use App\ReportReason;
use App\Topic;
use Exception;
use App\Channel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReplyController extends Controller
{
    private $user;
    private $discussion;
    private $channel;
    private $topic;
    private $item;
    private $reasons;

    function findOnId($id) {
        if ($this->item && $id == $this->item->id) return;
        $this->item = Reply::where('id', $id)->with('user')->with('upvotes')->with('downvotes')->with('reports')->first();
        if (!$this->item) throw new Exception('Data not found');
        $this->findRelations();
    }

    function findRelations() {
        $this->user = auth()->user();
        $this->discussion = Discussion::find($this->item->discussion_id);
        $this->topic = Topic::find($this->discussion->topic_id);
        $this->channel = Channel::find($this->topic->channel_id);
        $this->reasons = ReportReason::orderBy('id')->get();
    }

    function ifUnauthorized() {
        if (!$this->item) throw new Exception('Data not found');
        if (!$this->user) throw new Exception('User not found');
        if ($this->item->user_id != $this->user->id && !$this->user->isManager()) throw new Exception('Unauthorized access');
    }

    function ifSelfReport() {
        if ($this->item->user_id == $this->user->id) throw new Exception('Unauthorized access');
    }

    function redirectDiscussionOnError($exception) {
        if ($this->discussion) return redirect('/discussion/'.$this->discussion->slug)->with(['message' => $exception->getMessage(), 'success' => false]);
        else return redirect('/home')->with(['message' => $exception->getMessage(), 'success' => false]);
    }

    function redirectOnError($exception) {
        if ($this->discussion) return redirect('/reply/'.$this->item->id.'/report')->with(['message' => $exception->getMessage(), 'success' => false]);
        else return redirect('/home')->with(['message' => $exception->getMessage(), 'success' => false]);
    }

    function redirectDiscussion() {
        if ($this->discussion) return redirect('/discussion/'.$this->discussion->slug);
        else return redirect('/home')->with(['message' => 'Debug error!?', 'success' => false]);
    }

    function redirect() {
        if ($this->discussion) return redirect('/reply/'.$this->item->id.'/report');
        else return redirect('/home')->with(['message' => 'Debug error!?', 'success' => false]);
    }

    public function upvote($id)
    {
        try {
            $this->findOnId($id);
            $this->ifSelfReport();
            $item = ReplyUpvote::where('reply_id', $this->item->id)->where('user_id', $this->user->id)->first();
            if ($item) $item->delete();
            else {
                $item = new ReplyUpvote();
                $item->reply_id = $this->item->id;
                $item->user_id = $this->user->id;
                $item->save();

                $other = ReplyDownvote::where('reply_id', $this->item->id)->where('user_id', $this->user->id)->first();
                if ($other) $other->delete();
            }
            return $this->redirectDiscussion();
        } catch (Exception $exception){
            return $this->redirectDiscussionOnError($exception);
        }
    }

    public function downvote($id)
    {
        try {
            $this->findOnId($id);
            $this->ifSelfReport();
            $item = ReplyDownvote::where('reply_id', $this->item->id)->where('user_id', $this->user->id)->first();
            if ($item) $item->delete();
            else {
                $item = new ReplyDownvote();
                $item->reply_id = $this->item->id;
                $item->user_id = $this->user->id;
                $item->save();

                $other = ReplyUpvote::where('reply_id', $this->item->id)->where('user_id', $this->user->id)->first();
                if ($other) $other->delete();
            }
            return $this->redirectDiscussion();
        } catch (Exception $exception){
            return $this->redirectDiscussionOnError($exception);
        }
    }

    public function edit($id) {
        try {
            $this->findOnId($id);
            return view('user.reply.edit')->with(['item' => $this->item, 'channel' => $this->channel, 'topic' => $this->topic, 'discussion' => $this->discussion]);
        } catch (Exception $exception) {
            return $this->redirectOnError($exception);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $this->findOnId($id);
            $this->ifUnauthorized();
            if ($request->has('content')) $this->item->content = $request->input('content');
            $this->item->save();
            return $this->redirectDiscussion();
        } catch(Exception $exception) {
            return $this->redirectOnError($exception);
        }
    }

    public function investigate($id)
    {
        try {
            $this->findOnId($id);
            if ($this->item->user_id == $this->user->id) $this->item->reportable = true;
            $reports = ReplyReport::where('reply_id', $this->item->id)->with('user')->with('reason')->orderBy('updated_at', 'desc')->get();
            return view('user.reply.report')->with(['item' => $this->item, 'reports' => $reports, 'topic' => $this->topic, 'channel' => $this->channel, 'discussion' => $this->discussion, 'reasons' => $this->reasons]);
        } catch(Exception $exception) {
            return $this->redirectOnError($exception);
        }
    }

    public function report(Request $request, $id)
    {
        try {
            $this->findOnId($id);
            $this->ifSelfReport();
            if ($this->item->user_id == $this->user->id) $this->redirect();
            $get = ReplyReport::where('user_id', $this->user->id)->where('reply_id', $this->item->id)->first();

            // in case $get exists -> update
            if ($get) {
                if ($request->has('content')) $get->content = $request->input('content');
                if ($request->has('report_reason_id')) $get->report_reason_id = $request->input('report_reason_id');
                $get->save();
            } else {
                $item = new ReplyReport();
                $item->user_id = $this->user->id;
                $item->reply_id = $this->item->id;
                $item->content = $request->input('content');
                $item->report_reason_id = $request->input('report_reason_id');
                $item->save();
            }
            return $this->redirect();
        } catch (Exception $exception) {
            return $this->redirectOnError($exception);
        }
    }

    public function delete($id)
    {
        try {
            $this->findOnId($id);
            $this->ifUnauthorized();
            return view('user.reply.delete')->with(['discussion' => $this->discussion, 'item' => $this->item]);
        } catch (Exception $exception) {
            return $this->redirectOnError($exception);
        }
    }

    public function destroy($id)
    {
        try {
            $this->findOnId($id);
            $this->ifUnauthorized();
            ReplyUpvote::where('reply_id', $this->item->id)->delete();
            ReplyDownvote::where('reply_id', $this->item->id)->delete();
            ReplyReport::where('reply_id', $this->item->id)->delete();
            $this->item->delete();
            return redirect('/discussion/'.$this->discussion->slug);
        } catch (Exception $exception) {
            return $this->redirectOnError($exception);
        }
    }
}
