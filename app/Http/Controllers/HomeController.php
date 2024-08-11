<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{

    public function showRegistrationForm()
     {  
        if(Auth::guest()){
            return view('register');
        }else{
            if(Auth::user()->role === 'user'){
                return view('Home.homepage');
            }else{
                if(Auth::user()->role == "blogger"){
                    return redirect()->route('dashboard');
                }
                return redirect()->route('admindashboard'); 
            }
        }
     }


     public function showLoginForm()
     {
        if(Auth::guest()){
            return view('login');
        }else{
            if(Auth::user()->role === 'user'){
                return view('Home.homepage');
            }else{
                if(Auth::user()->role == "blogger"){
                    return redirect()->route('dashboard');
                }
                return redirect()->route('admindashboard'); 
            }
        }
         
     }

    
    public function showHomePage(){
        if(Auth::guest()){
            $categories = Category::all();
            $latestPost = Post::orderBy('created_at', 'desc')->first();
            $posts = Post::with('user','category')->paginate(4);
            return view('Home.homepage',compact(['posts','latestPost','categories']));
        }else{

            if(!Auth::user()->role == 'user'){
                return redirect()->route('dashboard');
            }else{
                $categories = Category::all();
                $latestPost = Post::orderBy('created_at', 'desc')->first();
                $posts = Post::with('user','category')->paginate(4);
                return view('Home.homepage',compact(['posts','latestPost','categories']));
            }

        }
    }

    public function bloggers(){
        $posts = Post::with('user')->get();
        $bloggers = User::withCount('followers')->where('role','blogger')->get();
        return view('Home.bloggers',compact('bloggers','posts')); 
    }

    public function allblogs(){
        if(Auth::guest()){
            $categories = Category::all();
            $latestPost = Post::orderBy('created_at', 'desc')->take(4)->get();
            $posts = Post::with('user','category')->paginate(4);
            return view('Home.allblogs',compact(['posts','latestPost','categories']));
        }else{

            if(!Auth::user()->role == 'user'){
                if(Auth::user()->role == "blogger"){
                    return redirect()->route('dashboard');
                }
                return redirect()->route('admindashboard'); 
            }else{
                $categories = Category::all();
                $latestPost = Post::orderBy('created_at', 'desc')->take(4)->get();
                $posts = Post::with('user','category')->paginate(4);
                return view('Home.allblogs',compact(['posts','latestPost','categories']));
            }

        }
    }

    public function showBlogPosts($id){
        if(Auth::guest()){
            $categories = Category::all();
            $posts = Post::with('user','category','comment.user','comment.replies.user','like')->find($id);
            return view('Home.postblog',compact(['posts','categories']));
        }else{
            if(Auth::user()->role == 'user'){
                $categories = Category::all();
                $posts = Post::with('user','category','comment.user','comment.replies.user')->find($id);
                // return $posts;
                return view('Home.postblog',compact(['posts','categories']));
            }else{
                if(Auth::user()->role == "blogger"){
                    return redirect()->route('dashboard');
                }
                return redirect()->route('admindashboard'); 
            }
        }
    }


    public function search(Request $request){
        $query = $request->search;
        if($query == null ||  $query == ""){
            return redirect()->back();
        }
        $searchResults = Post::with('user','category')->where("title","like","%{$query}%")
                        ->orWhere("description","like","%{$query}%")
                        ->get();
        return view('Home.search',compact('searchResults'));
      
    }


    // bloggers posts
    public function bloggerposts($id){
        $user = User::find($id);
        $posts = Post::with('user')->where('user_id',$id)->get();
        return view('Home.bloggerposts',compact('posts','user'));
    }

}
