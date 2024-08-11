<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class PostController extends Controller
{
   
    public function index()
    {   
        $user = Auth::user();
        if($user->role == 'blogger'){
            $posts = Post::with('user')->where('user_id',$user->id)->get();
            return view('blogger/allposts',compact('posts'));
        }else{
            $posts = Post::with('user')->get();
            return view('admin/allposts',compact('posts'));
        }
        
    }

    public function create()
    {
        if(Auth::user()->role == "blogger"){
            return view('blogger/addpost');
        }else{
            return view('admin/addpost');
        }
    }


    public function store(Request $request)
    {
           
       $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'user_id' => 'required|numeric',
            'category_id' => 'nullable',
            'comment_id' => 'nullable',
            'image' => 'nullable|image', 
        ]);
        

        $imagePath = null;

        if($request->hasFile('image')){
            $image = $request->file('image');
            $imageName = time() .'_'. $image->getClientOriginalName();
            $image->move(public_path('img'),$imageName);
            $imagePath = 'img/'. $imageName;
        }

        if(Auth::check()){
            $currentTime = Carbon::now();
        
            $post = Post::create([
                'title' => $request->title,
                'description' => $request->description,
                'user_id' => Auth::id(),
                'category_id' => $request->category_id,
                'image' => $imagePath,
            ]);
            $post->created_at->diffForHumans($currentTime);
        }

        if ($post) {
            return redirect()->route('post.index',$post->id)->with('success', 'Successful Posted!');
        } else {
            return redirect()->back()->withInput()->withErrors(['error' => 'Your post is Unsuccessfully not posted. Please try again.']);
        }
    }


    public function show($id)
    {
        $post = Post::with('user','comment.user','comment.replies.user')->find($id);
        if(Auth::user()->role == "blogger"){
            return view('blogger/viewpost', compact('post'));
        }else{
            return view('admin/viewpost', compact('post'));
        }
    }


    public function edit($id)
    {
        $categories = Category::all();
        $post = Post::with('user','category')->find($id);
        if(Auth::user()->role == "blogger"){
            return view('blogger/updatepost',compact(['post','categories']));
        }else{
            return view('admin/updatepost',compact(['post','categories']));
        }
    }


    public function update($postId, Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'category_id' => 'required|numeric',
            'image' => 'nullable|image', 
        ]);
        

        $post = Post::with('user')->find($postId); 
        if (!$post) {
            return redirect()->back()->with('error', 'Post not found.');
        }

        
         
        $post->title = $request->title;
        $post->description = $request->description;
        $post->category_id = $request->category_id;
        $post->save();

        if ($request->hasFile('image')) {
           File::delete(public_path('img/'.$post->image));

            $image = $request->file('image');
            $imageName = time() .'_'. $image->getClientOriginalName();
            $image->move(public_path('img'),$imageName);
            $imagePath = 'img/'.$imageName;
            $post->image = $imagePath;
            $post->save();
        }
       
        return redirect()->route('post.show', $post->id)->with('success', 'Post successfully updated!');
    }

    public function destroy($id)
    {
        $post = Post::find($id);
        if ($post->image) {
            File::delete(public_path('img/'.$post->image));
        }
        $post->delete();
        return redirect()->route('post.index')->with('success','Post Successfully Deleted!');
    }


    public function showPostById(Request $request){
        $request->validate([
            'id' => 'required|numeric',
        ]);
        $id = Auth::user()->id;
        $categories = Category::all();
        $post = Post::where('user_id',$id)->find($request->id);
        return view('admin/updateById',compact(['post','categories']));
    }

    public function showPostOnDelete(Request $request){
        $request->validate([
            'id' => 'required|numeric',
        ]);
        $id = Auth::user()->id;
        $post = Post::where('user_id',$id)->find($request->id);
        if(isset($post)){
            return view('admin/deletebyid',['post'=>$post]);
        }else{
            return redirect()->route('updateById')->with('error', 'Post not found.');
        }
    }

    public function destroyById($id)
    {

        $post = Post::find($id);
        if ($post->image) {
            File::delete(public_path('img/'.$post->image));
        }
        $post->delete();
        return redirect()->route('post.index')->with('success','Post Successfully Deleted!');
    }

   
}
