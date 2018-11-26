<?php

namespace App\Http\Controllers\User;

use App\Discussion;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index() {
        $user = auth()->user();
        $views = Discussion::orderBy('views', 'desc')->take(5)->get();
        $replies = Discussion::withCount('replies')->orderBy('replies_count', 'desc')->take(5)->get();
        if ($user) {
            $user = User::find($user->id);
            $bookmarked = $user->bookmarked()->take(5)->get();
            $discussions = $user->discussions()->take(5)->get();
            return view('user.home.index')->with(['views' => $views, 'replies' => $replies, 'bookmarked' => $bookmarked, 'discussions' => $discussions]);
        } else
            return view('user.home.index')->with(['views' => $views, 'replies' => $replies]);
    }

    public function search(Request $request) {
        if ($request->has('search')) {
            $search = $request->input('search');
            $items = Discussion::where('title', 'like', '%'.$search.'%')->orWhere('content', 'like', '%'.$search.'%')->orderBy('updated_at')->paginate(10);
            return view('user.home.search')->with(['items' => $items, 'search' => $search]);
        } return view('user.home.search')->with(['search' => '']);
    }

    public function top(Request $request)
    {
        $order = $request->has('view') ? $request->input('view') : 'latest';
        switch ($order) {
            case "views": $items = Discussion::orderBy('views', 'desc')->paginate(10); break;
            case "replies": $items = Discussion::withCount('replies')->orderBy('replies_count', 'desc')->paginate(10); break;
            case "latest": $items = Discussion::orderBy('created_at', 'desc')->paginate(10); break;
            case "updated": $items = Discussion::orderBy('updated_at', 'desc')->paginate(10); break;
            default: $items = Discussion::orderBy('updated_at', 'desc')->paginate(10);
        }
        return view('user.home.top')->with(['items' => $items]);
    }

    public function bookmark(Request $request) {
        $order = $request->has('view') ? $request->input('view') : 'bookmarked';
        switch ($order) {
            case "bookmarked": $items = User::bookmarkedDiscussions(); break;
            case "posted": $items = User::postedDiscussions(); break;
            case "replied": $items = User::repliedDiscussions(); break;
            case "reported": $items = User::reportedDiscussions(); break;
            default: $items = User::bookmarkedDiscussions();
        }
        return view('user.home.bookmark')->with(['items' => $items]);
    }

}
