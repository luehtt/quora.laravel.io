<?php

namespace App\Http\Controllers\Manage;

use App\Channel;
use App\Discussion;
use App\DiscussionReport;
use App\Http\Controllers\Controller;
use App\Reply;
use App\ReplyReport;
use App\Topic;
use App\User;
use Exception;
use Illuminate\Http\Request;

class ManageUserController extends Controller
{
    private $item;
    private $discussed;
    private $replied;
    private $discussedReported;
    private $repliedReported;

    function findById($id) {
        $this->item = User::find($id);
        if (!$this->item) throw new Exception('Data not found');
    }

    function findRelations() {
        $this->discussed = Discussion::where('user_id', $this->item->id)->paginate(10);
        $this->item->discussed = $this->discussed->total();

        $this->replied = Reply::where('user_id', $this->item->id)->paginate(10);
        $this->item->replied = $this->replied->total();

        // cannot use pluck due to items() being array not collection
        $discussed_ids = array_column($this->discussed->items(), 'id');
        $this->discussedReported = DiscussionReport::whereIn('discussion_id', $discussed_ids)->paginate(10);
        $this->item->discussedReported = $this->discussedReported->total();

        $replied_ids = array_column($this->replied->items(), 'id');
        $this->repliedReported = ReplyReport::whereIn('reply_id', $replied_ids)->paginate(10);
        $this->item->repliedReported = $this->repliedReported->total();
    }

    function redirectOnError($exception) {
        return redirect('/manage/user')->with(['message' => $exception->getMessage(), 'success' => false]);
    }

    function redirect() {
        return redirect('/manage/user')->with(['message' => 'Commission succeeded', 'success' => true]);
    }

    public function index()
    {
        $items = User::where('user_role_id', '<>', 1)->orderBy('name')->paginate(20);
        return view('manage.user.index')->with(['items' => $items]);
    }

    public function show(Request $request, $id)
    {
        try {
            $this->findById($id);
            $this->findRelations();
            $order = $request->has('view') ? $request->input('view') : 'discussed';
            switch ($order) {
                case "discussed":
                    return view('manage.user.show')->with(['item' => $this->item, 'discussed' => $this->discussed]);
                case "replied":
                    return view('manage.user.show')->with(['item' => $this->item, 'replied' => $this->replied]);
                case "discussedReported":
                    return view('manage.user.show')->with(['item' => $this->item, 'discussedReported' => $this->discussedReported]);
                case "repliedReported":
                    return view('manage.user.show')->with(['item' => $this->item, 'repliedReported' => $this->repliedReported]);
                default:
                    return view('manage.user.show')->with(['item' => $this->item, 'discussed' => $this->discussed]);
            }
        } catch (Exception $exception) {
            return $this->redirectOnError($exception);
        }
    }

    public function enable($id) {
        try {
            $this->findById($id);
            if ($this->item->enabled == true) $this->item->enabled = false;
            elseif ($this->item->enabled == false) $this->item->enabled = true;
            $this->item->save();
            return redirect('/manage/user/'.$id);
        } catch (Exception $exception) {
            return $this->redirectOnError($exception);
        }
    }
}
