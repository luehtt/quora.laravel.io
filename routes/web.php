<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () { return view('intro'); })->name('intro');
Route::get('/unauthorized', function () { return view('unauthorized'); })->name('unauthorized');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::prefix('/manage')->middleware('admin')->group(function(){
    Route::get('/', 'Manage\ManageChannelController@index');
    Route::resource('/channel', 'Manage\ManageChannelController');
    Route::get('/channel/{channel}/delete', 'Manage\ManageChannelController@delete')->name('channel.delete');

    Route::resource('/topic', 'Manage\ManageTopicController', ['except' => ['create']]);
    Route::get('/channel/{channel}/topic/create', 'Manage\ManageTopicController@create')->name('topic.create');
    Route::get('/topic/{topic}/delete', 'Manage\ManageTopicController@delete')->name('topic.delete');

    Route::get('/user', 'Manage\ManageUserController@index')->name('user.index');
    Route::get('/user/{user}', 'Manage\ManageUserController@show')->name('user.show');
    Route::put('/user/{user}/enable', 'Manage\ManageUserController@enable')->name('user.enable');

    Route::get('/discussion/bookmark', 'Manage\ManageDiscussionController@index')->name('discussion.bookmark.index');
    Route::get('/discussion/{discussion}/bookmark', 'Manage\ManageDiscussionController@bookmark')->name('discussion.bookmark.edit');
    Route::get('/discussion/{discussion}/delete', 'Manage\ManageDiscussionController@delete')->name('discussion.delete');
    Route::delete('/discussion/{discussion}', 'Manage\ManageDiscussionController@destroy')->name('discussion.destroy');
});

Route::name('user.')->middleware('manager')->group(function(){
    Route::get('/discussion/{discussion}/edit', 'User\DiscussionController@edit')->name('discussion.edit');
    Route::put('/discussion/{discussion}/edit', 'User\DiscussionController@update')->name('discussion.update');
    Route::get('/reply/{reply}/edit', 'User\ReplyController@edit')->name('reply.edit');
    Route::put('/reply/{reply}/edit', 'User\ReplyController@update')->name('reply.update');

});

Route::name('user.')->middleware('auth')->group(function(){
    Route::get('/bookmark', 'User\HomeController@bookmark')->name('home.bookmark');
    Route::post('/topic/{topic}/bookmark', 'User\ChannelController@bookmark')->name('topic.bookmark');

    Route::get('/account', 'User\AccountController@index')->name('account.index');
    Route::post('/account/photo', 'User\AccountController@photo')->name('account.photo');
    Route::post('/account/password', 'User\AccountController@password')->name('account.password');

    Route::get('/discussion/topic/{topic}', 'User\DiscussionController@create')->name('discussion.create');
    Route::post('/discussion', 'User\DiscussionController@store')->name('discussion.store');
    Route::name('discussion.')->prefix('/discussion/{discussion}')->group(function () {
        Route::get('/', 'User\DiscussionController@show')->name('show');
        Route::post('/bookmark', 'User\DiscussionController@bookmark')->name('bookmark');
        Route::post('/reply', 'User\DiscussionController@reply')->name('reply');
        Route::get('/report', 'User\DiscussionController@investigate')->name('investigate');
        Route::post('/report', 'User\DiscussionController@report')->name('report');
        Route::get('/archive', 'User\DiscussionController@close')->name('close');
        Route::post('/archive', 'User\DiscussionController@archive')->name('archive');
        Route::get('/delete', 'User\DiscussionController@delete')->name('delete');
        Route::delete('/delete', 'User\DiscussionController@destroy')->name('destroy');
    });

    Route::name('reply.')->prefix('reply/{reply}')->group(function () {
        Route::post('/upvote', 'User\ReplyController@upvote')->name('upvote');
        Route::post('/downvote', 'User\ReplyController@downvote')->name('downvote');
        Route::get('/report', 'User\ReplyController@investigate')->name('investigate');
        Route::post('/report', 'User\ReplyController@report')->name('report');
        Route::get('/delete', 'User\ReplyController@delete')->name('delete');
        Route::delete('/delete', 'User\ReplyController@destroy')->name('destroy');
    });
});

Route::name('user.home.')->group(function(){
    Route::get('/home', 'User\HomeController@index')->name('index');
    Route::get('/top', 'User\HomeController@top')->name('top');
    Route::get('/search', 'User\HomeController@search')->name('search');
});

Route::name('public.channel.')->prefix('/channel')->group(function(){
    Route::get('/', 'User\ChannelController@index')->name('index');
    Route::get('/{channel}', 'User\ChannelController@channel')->name('show');
    Route::get('/topic/{topic}', 'User\ChannelController@topic')->name('topic');
});





