<?php

namespace App\Http\Controllers\User;


use App\Discussion;
use App\Http\Controllers\Controller;
use App\Topic;
use App\TopicBookmark;
use App\User;
use App\UserRole;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;


class AccountController extends Controller
{
    public function index()
    {
        $item = User::where('id', auth()->user()->id)->withCount('discussions')->withCount('replies')
            ->withCount('discussion_reports')->withCount('reply_reports')
            ->withCount('reply_upvotes')->withCount('reply_downvotes')->first();
        return view('user.home.account')->with(['item' => $item]);
    }

    public function photo(Request $request)
    {
        if (!$request->hasFile('photo')) return redirect('/account');
        try {
            $upload = $request->file('photo');
            $file = pathinfo($upload->getClientOriginalName(), PATHINFO_FILENAME);
            $filename = str_slug($file).'-'.time().'.'.$upload->getClientOriginalExtension();
            $store = $upload->storeAs('public/img/user', $filename);

            $item = User::find(auth()->user()->id);
            if ($item->photo != null && $item->photo != 'default-ninja.png') Storage::delete('public/img/user/'.$item->photo);
            $item->photo = $filename;
            $item->save();
            return redirect('/account')->with(['message' => 'Function succeeded', 'success' => true]);
        } catch (Exception $exception) {
            return $this->redirectOnError($exception->getMessage());
        }
    }

    public function password(Request $request)
    {
        try {
            $require_password = $request->input('require-password');
            $password = $request->input('password');
            $confirm_password = $request->input('confirm-password');
            $current_password = auth()->user()->password;

            if (!Hash::check($require_password, $current_password)) return $this->redirectOnError('Entered Password unauthenticated');
            if ($password != $confirm_password) return $this->redirectOnError('Entered Password mismatched');

            $item = User::find(auth()->user()->id);
            $item->password = Hash::make($password);
            $item->save();
            return redirect('/account')->with(['message' => 'Function succeeded', 'success' => true]);
        } catch (Exception $exception) {
            return $this->redirectOnError($exception->getMessage());
        }
    }

    function redirectOnError($message) {
        return redirect('/account')->with(['message' => $message, 'success' => false]);
    }
}
