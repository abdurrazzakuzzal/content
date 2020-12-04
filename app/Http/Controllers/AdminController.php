<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Story;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $allstories = Story::select('*')
                    ->get();

        return view('home', ['allstories'=>$allstories]);
    }

    public function approveStory(Request $request, $id)
    {
        $approve = Story::where('id', $id)
                    ->update(array('approved' => '1'));

        return back()->withInput();
    }

    public function unapproveStory(Request $request, $id)
    {
        $approve = Story::where('id', $id)
                    ->update(array('approved' => '0'));

        return back()->withInput();
    }
}
