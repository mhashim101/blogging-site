<?php

namespace App\Http\Controllers;

use App\Models\Reply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReplyController extends Controller
{
    public function storeReply(Request $request){
        $request->validate([
            'body' => 'required|string',
            // 'user_id' => 'required|numeric',
            'comment_id' => 'required|numeric',
            'reply_id' => 'nullable',
        ]);

        $replies = Reply::create([
            'body' => $request->body,
            'user_id' => Auth::user()->id,
            // 'post_id' => $request->post_id,
            'comment_id' => $request->comment_id,
            'reply_id' => $request->reply_id,
        ]);

        if ($replies) {
            if(Auth::user()->role == "vendor" || Auth::user()->role == "admin"){
                return redirect()->back();
            }
            return redirect()->route('blogposts',$request->post_id);
        }else{
            return redirect()->back()->with('error', 'Reply could not be added.');
        }
    

    }

    public function show($id){
        $repliesOfSpecifiedComment = Reply::with('user')->where('comment_id',$id)->get();
        return view('admin/replies',['replies' => $repliesOfSpecifiedComment]);
    }

    public function destroy($id){
        $reply = Reply::find($id);
        $reply->delete();
        return redirect()->back()->with('success','Reply Successfully Deleted');
    }
}
