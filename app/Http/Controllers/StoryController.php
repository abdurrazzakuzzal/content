<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment;
use App\Story;
use App\User;
use DB;

class StoryController extends Controller
{
    //post story
    public function postStory(Request $request){
        $user = $request->user();

        if ($files = $request->file('images')) {
            // Define upload path
            $destinationPath = public_path('image'); // upload path
         // Upload Orginal Image           
            $profileImage = date('YmdHis') . "." . $files->getClientOriginalExtension();
            $files->move($destinationPath, $profileImage);
        }

        Story::insert([
            'title' => $request->input('title'),
            'body' => $request->input('story'),
            'section' => $request->input('section'),
            'tags' => $request->input('tags'),
            'images' => $profileImage,
            'writer_id' => $user->id,
            'approved' => '0',
        ]);

        return back()->withInput();
    }

    //count like
    public function likes(Request $request, $id)
    {
        $user = $request->user();

        $alreadyLiked = DB::table('likes')
                        ->where('story_id', $id)
                        ->where('user_id', $user->id)
                        ->first();

       
        if ( $alreadyLiked == null) {
            DB::table('likes')
                ->insert([
                    'story_id' => $id,
                    'user_id'  => $user->id
                ]);
        }
        else {
            return redirect()->route('welcome')->with('alert', 'You have already liked the story!');
        }
        
        return redirect()->route('welcome')->with('alert', 'You have liked the story!');
    }

    //get story to edit
    public function editStory(Request $request, $id)
    {
        $story = Story::select('*')
                    ->where('id', $id)
                    ->first();

        return view('editStory', ['story'=>$story]);
    }

    //update edited story
    public function updateStory(Request $request)
    {
        if ($files = $request->file('images')) {
            // Define upload path
            $destinationPath = public_path('image'); // upload path
         // Upload Orginal Image           
            $profileImage = date('YmdHis') . "." . $files->getClientOriginalExtension();
            $files->move($destinationPath, $profileImage);
        }

        Story::where('id', $request->input('id'))
            ->update([
                'title' => $request->input('title'),
                'body' => $request->input('story'),
                'section' => $request->input('section'),
                'tags' => $request->input('tags'),
                'images' => $profileImage
            ]);

        return redirect()->route('home')->with('alert', 'Story Updated!');
    }

    //delete story
    public function deleteStory($id)
    {
        Story::destroy($id);

        return redirect()->route('home')->with('alert', 'Story Delete!');
    }

    //store comments and replies
    public function storeComment(Request $request)
    {
    	$request->validate([
            'body'=>'required',
        ]);
   
        $input = $request->all();
        $input['user_id'] = auth()->user()->id;
    
        Comment::create($input);
   
        return back();
    }

    //share story
    public function shareStory(Request $request, $id)
    {
        $user = $request->user();

        $alreadyShared = DB::table('shares')
                        ->where('story_id', $id)
                        ->where('user_id', $user->id)
                        ->first();

       
        if ( $alreadyShared == null) {
            DB::table('shares')
                ->insert([
                    'story_id' => $id,
                    'user_id'  => $user->id
                ]);
        }
        else {
            return redirect()->route('welcome')->with('alert', 'You have already shared the story!');
        }
        
        return redirect()->route('welcome')->with('alert', 'You have shared the story!');
    }
}
