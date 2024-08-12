<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\FollowNotification;
use Illuminate\Support\Facades\Notification;

class FollowController extends Controller
{
    public function follow($bloggerId)
    {   
        $follower = Auth::user();
        $blogger = User::find($bloggerId);
        $blogger->followers()->attach($follower->id);
        Notification::send($blogger,new FollowNotification($follower));
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
