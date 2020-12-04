<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Story;
use DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

     //get data for homepage
    public function index(Request $request)
    {
        $user = $request->user();

        $stories = Story::select('*')
            ->where('writer_id', $user->id)
            ->get();

        $comments = DB::table('comments')
            ->join('users', 'comments.user_id', '=', 'users.id')
            ->select('comments.*', 'users.name', 'users.avatar')
            ->get();

        $sharedStories = DB::table('shares')
            ->join('stories', 'shares.story_id', '=', 'stories.id')
            ->join('users', 'stories.writer_id', '=', 'users.id')
            ->where('user_id', $user->id)
            ->select('stories.*', 'users.*', 'shares.*')
            ->get();

        $likes = DB::table('likes')
            ->groupBy('story_id')
            ->select('*', DB::raw('count(*) as likes'))
            ->get();

        return view('home', ['user'=>$user, 'stories'=>$stories, 'comments'=>$comments, 'sharedStories'=>$sharedStories, 'likes'=>$likes]);
    }


    //get user to edit user profile
    public function editProfile(Request $request)
    {
        $user = $request->user();

        return view('editProfile', ['user'=>$user]);
    }

    //update edited user profile
    public function updateProfile(Request $request)
    {
        $user = $request->user();

        if ($files = $request->file('avatar')) {
            // Define upload path
            $destinationPath = public_path('image'); // upload path
         // Upload Orginal Image           
            $profileImage = date('YmdHis') . "." . $files->getClientOriginalExtension();
            $files->move($destinationPath, $profileImage);
        }

        User::where('id', $user->id)
            ->update([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'date_of_birth' => $request->input('date_of_birth'),
                'gender' => $request->input('gender'),
                'phone_number' => $request->input('phone_number'),
                'avatar' => $profileImage
            ]);

        return redirect()->route('home')->with('alert', 'Profile Updated!');
    }
}
