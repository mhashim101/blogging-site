<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FollowController extends Controller
{
    public function follow($bloggerId)
    {   
        $user_id = Auth::user()->id;
        $user = User::find($bloggerId);
        $user->followers()->attach($user_id);
        return redirect()->back();
    }

    public function unfollow($bloggerId)
    {   
        $user_id = Auth::user()->id;
        $user = User::find($bloggerId);
        $user->followers()->detach($user_id);
        return redirect()->back();
    }
}
