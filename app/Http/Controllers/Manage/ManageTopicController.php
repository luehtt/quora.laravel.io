<?php

namespace App\Http\Controllers\Manage;

use App\Channel;
use App\Discussion;
use App\Http\Controllers\Controller;
use App\Topic;
use Exception;
use Illuminate\Http\Request;

class ManageTopicController extends Controller
{
    function findOnId($id) {
        $item = Topic::where('id', $id)->with('channel')->first();
        if (!$item) throw new Exception('Data not found');
        return $item;
    }

    function redirectOnError($exception) {
        return redirect('/manage/topic')->with(['message' => $exception->getMessage(), 'success' => false]);
    }

    function redirect() {
        return redirect('/manage/topic')->with(['message' => 'Commission succeeded', 'success' => true]);
    }

    public function index()
    {
        $items = Topic::orderBy('channel_id')->paginate(20);
        $channels = Channel::all();
        return view('manage.topic.index')->with(['items' => $items, 'channels' => $channels]);
    }

    public function show($id)
    {
        try {
            $topic = $this->findOnId($id);
            $items = Discussion::where('topic_id', $topic->id)->with('replies')->orderBy('id')->paginate(20);
            return view('manage.topic.show')->with(['topic' => $topic, 'items' => $items]);
        } catch (Exception $exception) {
            return $this->redirectOnError($exception);
        }
    }

    public function create($channel_id)
    {
        $groups = Channel::all();
        $channel = Channel::find($channel_id);
        return view('manage.topic.create')->with(['groups' => $groups, 'channel' => $channel]);
    }

    public function store(Request $request)
    {
        try {
            $item = new Topic();
            $item->name = $request->input('name');
            $item->slug = str_slug($item->name);
            $item->description = $request->input('description');
            $item->channel_id = $request->input('channel_id');
            $item->save();
            return $this->redirect();
        } catch (Exception $exception) {
            return $this->redirectOnError($exception);
        }
    }

    public function edit($id)
    {
        try {
            $item = $this->findOnId($id);
            $channel = $item->channel;
            $groups = Channel::all();
            return view('manage.topic.edit')->with(['item' => $item, 'groups' => $groups, 'channel' => $channel]);
        } catch (Exception $exception) {
            return $this->redirectOnError($exception);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $item = $this->findOnId($id);
            if ($request->has('name')) $item->name = $request->input('name');
            if ($request->has('name'))  $item->slug = str_slug($item->name);
            if ($request->has('description')) $item->description = $request->input('description');
            if ($request->has('channel_id')) $item->channel_id = $request->input('channel_id');
            $item->save();
            return $this->redirect();
        } catch (Exception $exception) {
            return $this->redirectOnError($exception);
        }
    }

    public function delete($id)
    {
        try {
            $item = $this->findOnId($id);
            return view('manage.topic.delete')->with(['item' => $item]);
        } catch (Exception $exception) {
            return $this->redirectOnError($exception);
        }
    }

    public function destroy($id)
    {
        try {
            $item = $this->findOnId($id);
            $item->delete();
            return $this->redirect();
        } catch (Exception $exception) {
            return $this->redirectOnError($exception);
        }
    }
}
