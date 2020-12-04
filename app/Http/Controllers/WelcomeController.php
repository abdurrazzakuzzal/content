<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class WelcomeController extends Controller
{
    //get data for welcome page
    public function index(Request $request)
    {
        $stories = DB::table('stories')
                    ->join('users', 'stories.writer_id', '=', 'users.id')
                    ->select('stories.*', 'users.name', 'users.avatar')
                    ->get();
        
        $likes = DB::table('likes')
                    ->groupBy('story_id')
                    ->select('*', DB::raw('count(*) as likes'))
                    ->get();

        $comments = DB::table('comments')
                    ->join('users', 'comments.user_id', '=', 'users.id')
                    ->select('comments.*', 'users.name', 'users.avatar')
                    ->get();

        return view('welcome', ['stories'=>$stories, 'comments'=>$comments, 'likes'=>$likes]);
    }
}
