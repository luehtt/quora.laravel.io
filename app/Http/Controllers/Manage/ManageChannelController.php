<?php

namespace App\Http\Controllers\Manage;

use App\Channel;
use App\Http\Controllers\Controller;
use App\Topic;
use Exception;
use Illuminate\Http\Request;

class ManageChannelController extends Controller
{
    function findOnId($id) {
        $item = Channel::find($id);
        if (!$item) throw new Exception('Data not found');
        return $item;
    }

    function redirectOnError($exception) {
		return redirect('/manage/channel')->with(['message' => $exception->getMessage(), 'success' => false]);
	}
	
	function redirect() {
        return redirect('/manage/channel')->with(['message' => 'Commission succeeded', 'success' => true]);
    }
	
    public function index()
    {
        $items = Channel::with('topics')->orderBy('id')->paginate(20);
        return view('manage.channel.index')->with(['items' => $items]);
    }

    public function create()
    {
        return view('manage.channel.create');
    }

    public function store(Request $request)
    {
        try {
            $item = new Channel();
            $item->name = $request->input('name');
            $item->slug = str_slug($item->name);
            $item->description = $request->input('description');
            $item->save();
            return $this->redirect();
        } catch (Exception $exception) {
            return $this->redirectOnError($exception);
        }
    }

    public function show($id)
    {
        try {
            $channel = $this->findOnId($id);
            $items = Topic::where('channel_id', $channel->id)->with('discussions')->orderBy('id')->paginate(20);
            return view('manage.channel.show')->with(['channel' => $channel, 'items' => $items]);
        } catch (Exception $exception) {
            return $this->redirectOnError($exception);
        }
    }

    public function edit($id)
    {
        try {
            $item = $this->findOnId($id);
            return view('manage.channel.edit')->with(['item' => $item]);
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
            return view('manage.channel.delete')->with(['item' => $item]);
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
