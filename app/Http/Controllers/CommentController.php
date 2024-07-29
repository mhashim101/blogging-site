<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request){
        $request->validate([
            'body' => 'required|string',
            'user_id' => 'required|numeric',
            'post_id' => 'required|numeric',
        ]);

        $comment = Comment::create([
            'body' => $request->body,
            'user_id' => $request->user_id,
            'post_id' => $request->post_id,
        ]);

        if ($comment) {
            // $post = Post::with('user', 'category', 'comment')->find($request->post_id);
            // $comments = Comment::with('user','post')->where('post_id',$request->post_id)->get();
            return redirect()->route('blogposts',$request->post_id);
        }
    
        return redirect()->back()->with('error', 'Comment could not be added.');
    }


    // public function show($id){
    //     $comment = Comment::with('post','user')->findOrFail($id);
    //     return view('viewpost',compact('comment'));
    // }






























    // public function showComments(){
    //     $comments = Comment::with('post')->get();
    //     if($comments){
    //         return view('comments',compact('comments'));
    //     }else{
    //         return view('comments');
    //     }
    // }
    // public function pushComment(Request $request){
    //     $request->validate([
    //         'author' => 'required|string',
    //         'email' => 'required|email',
    //         'comment' => 'required|string',
    //         'post_id' => 'required|numeric',
    //     ]);
    //     $comments = Comment::create([
    //         'author' => $request->author,
    //         'email' => $request->email,
    //         'comment' => $request->comment,
    //         'post_id' => $request->post_id,
    //     ]);
        
    //     if($comments){
    //         return redirect()->route('blogposts',$request->post_id)->with('success','Your comment is successfully posted!');
    //     }
    // }

   
    // public function destroyComment($id){
    //     $comment = Comment::find($id);
    //     $comment->delete();
    //     return redirect()->route('comments')->with('success','Post Successfully Deleted!');
    // }
}
