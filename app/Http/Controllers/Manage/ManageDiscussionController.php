<?php

namespace App\Http\Controllers\Manage;

use App\Channel;
use App\DiscussionBookmark;
use App\DiscussionReport;
use App\Http\Controllers\Controller;
use App\Discussion;
use App\Reply;
use App\ReplyDownvote;
use App\ReplyReport;
use App\ReplyUpvote;
use App\User;
use Exception;
use Illuminate\Http\Request;

class ManageDiscussionController extends Controller
{
    function findOnId($id) {
        $item = Discussion::where('id', $id)->with('topic')->first();
        if (!$item) throw new Exception('Data not found');
        return $item;
    }

    function redirectOnError($exception) {
        return redirect('/manage/topic')->with(['message' => $exception->getMessage(), 'success' => false]);
    }

    function redirect() {
        return redirect('/manage/topic')->with(['message' => 'Commission succeeded', 'success' => true]);
    }

    public function delete($id)
    {
        try {
            $item = $this->findOnId($id);
            return view('manage.discuss.delete')->with(['item' => $item]);
        } catch (Exception $exception) {
            return $this->redirectOnError($exception);
        }
    }

    public function bookmark($id)
    {
        try {
            $item = $this->findOnId($id);
            $user = auth()->user();
            $bookmark = DiscussionBookmark::where('user_id', $user->id)->where('discussion_id', $id)->first();
            if ($bookmark) $bookmark->delete();
            else {
                $bookmark = new DiscussionBookmark();
                $bookmark->user_id = $user->id;
                $bookmark->discussion_id = $id;
                $bookmark->save();
            }

            return redirect('/manage/topic/'.$item->topic->id);
        } catch (Exception $exception) {
            return $this->redirectOnError($exception);
        }
    }

    public function index() {
        return view('manage.discuss.bookmark')->with(['items' => User::bookmarkedDiscussions()]);
    }

    public function destroy($id)
    {
        try {
            $item = $this->findOnId($id);

            DiscussionBookmark::where('discussion_id', $item->id)->delete();
            DiscussionReport::where('discussion_id', $item->id)->delete();


            $replies = Reply::where('discussion_id', $item->id)->get();
            foreach ($replies as $i) {
                ReplyUpvote::where('reply_id', $i->id)->delete();
                ReplyDownvote::where('reply_id', $i->id)->delete();
                ReplyReport::where('reply_id', $i->id)->delete();
            }
            Reply::where('discussion_id', $item->id)->delete();

            $item->delete();
            return $this->redirect();
        } catch (Exception $exception) {
            return $this->redirectOnError($exception);
        }
    }
}
