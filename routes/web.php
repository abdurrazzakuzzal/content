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

Route::get('/', 'WelcomeController@index')->name('welcome');

Auth::routes();

Route::group(['prefix' => 'home'], function () {
    Route::get('/', 'HomeController@index')->name('home');
    Route::post('/', 'StoryController@postStory')->name('post.story');
    Route::get('/{id}', 'StoryController@likes')->name('like');
    Route::get('/editProfile', 'HomeController@editProfile')->name('edit.profile');
    Route::get('/editStory/{id}', 'StoryController@editStory')->name('edit.story');
    Route::post('/updateProfile', 'StoryController@updateProfile')->name('update.profile');
    Route::post('/updateStory', 'StoryController@updateStory')->name('update.story');
    Route::get('/deleteStory/{id}', 'StoryController@deleteStory')->name('delete.story');
    Route::get('/share/{id}', 'StoryController@shareStory')->name('share.story');
    Route::post('/comment', 'StoryController@storeComment')->name('comments.store');
});


Route::group(['prefix' => 'admin'], function () {
    Route::get('/{id}', 'AdminController@approveStory')->name('approve.story');
    Route::get('/{id}/unapprove', 'AdminController@unapproveStory')->name('unapprove.story');
});
