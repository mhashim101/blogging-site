<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function index(){
        $likes = Like::all();
        dd($likes);
    }

    public function likePost($postId){
        $post = Post::findOrFail($postId);
        $like = new Like();
        $like->user_id = Auth::user()->id;
        $like->post_id = $post->id;
        $like->save();

        return back();
 
    }

    public function unlikePost($postId){
        $post = Post::findOrFail($postId);
        $post->like()->where('user_id',Auth::user()->id)->delete();
        
        return back();
    }
}
