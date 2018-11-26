<?php
/**
 * Created by PhpStorm.
 * User: Lue
 * Date: 10/19/2018
 * Time: 10:28 AM
 */

namespace App\Http\Composers;

use App\Topic;
use App\TopicBookmark;
use Illuminate\View\View;

class TopicBookmarkComposer
{
    public function compose(View $view)
    {
        if (auth()->user()) {
            $user = auth()->user();
            $bookmarks = TopicBookmark::where('user_id', $user->id)->get();
            $ids = $bookmarks->pluck('topic_id');
            $items = Topic::whereIn('id', $ids)->get();
            $view->with('topic_bookmarks', $items);
        }
    }
}