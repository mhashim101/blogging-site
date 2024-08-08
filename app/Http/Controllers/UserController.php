<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Models\EmailVerificationToken;


class UserController extends Controller
{

    // All bloggers
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


    public function editUserPage($id){
        $user = User::findOrFail($id);
        return view('admin/edituser',compact('user'));
    }


    public function updateUser($id, Request $request){
       $validate = $request->validate([
        'name' => 'required|string',
        'email' => 'required|email',
        'role' => 'required|string',
        'profile' => 'nullable|image|string',
       ]);

       $imagePath = null;
       $user = User::findOrFail($id);

       if($request->hasFile('profile')){

            File::delete(public_path('img/'.$user->profile));


            $image = $request->file('profile');
            $imageName = time().'_'.$image->getClientOriginalName();
            $image->move(public_path('img'),$imageName);
            $imagePath = 'img/'.$imageName;
            $user->profile = $imagePath;
            $user->save();

       }

       $user->name = $request->name;
       $user->email = $request->email;
       $user->role = $request->role;
       $user->save();

       return redirect()->route('allusers')->with('success','Record updated successfully!');
       
    }

    public function changeRole(Request $request){
        $validated = $request->validate([
            'role' => 'required|string|max:255',
        ]);
    
        // Assuming user_id is passed through a hidden field or another way
        $user = User::find($request->user_id);
        $user->role = $request->role;
        $user->save();
    
        return redirect()->route('allusers');
    }

    public function postByCategory($id){
        $categories = Category::all();
        $postByCategory = Post::with('category')->where('category_id',$id)->get();
        return view('Home.postcategory',['posts' => $postByCategory,'categories' => $categories]);
    }

    // Homepage of site
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


     // Show registration form
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

     // Show login form
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
     // Show dashboard form
     public function dashboardPage()
     {  
        if(Auth::user()->role == "blogger"){
            return view('blogger/dashboard');
        }else{
            return view('admin/dashboard');
        }
     }
     // Show dashboard form
     public function showAllUsersPage()
     {
        if(Auth::guest()){
            return view('login');
        }else{
            if(Auth::user()->role == 'blogger'){
                return redirect()->route('dashboard');
            }else{
                $users  = User::where('id','!=',Auth::user()->id)->paginate(5);
                return view('admin/allusers',compact('users'));
            }
        }

        
     }
     public function destroyUser($id)
     {

        if(Auth::guest()){
            return view('login');
        }else{

            if(Auth::user()->role == 'blogger'){
                return redirect()->route('dashboard');
            }else{
                $user = User::find($id);
                if ($user->profile) {
                    File::delete(public_path('img/'.$user->profile));
                }

                $user->delete();
                return redirect()->route('allusers')->with('success','User Successfully Deleted!');
            }
        }
       
     }
     // Show addPostPage form
     public function addPostPage()
     {  
         $categories = Category::all();
        if(Auth::user()->role == 'blogger'){
            return view('blogger/addpost',compact('categories'));
         }else{
            return view('admin/addpost',compact('categories'));
         }
     }
     // Show showCategoriesPage
     public function showCategoriesPage()
     {  
        if(Auth::user()->role == 'blogger'){
            return redirect()->route('dashboard');
        }
        $categories = Category::all();
         return view('admin/categories',compact('categories'));
     }
   
     public function showAddCategoryPage()
     {  
        if(Auth::user()->role == 'blogger'){
            return redirect()->route('dashboard');
        }
        return view('admin/addcategory');
     }
     // Show showAddCategoryPage
     public function addcategory(Request $request)
     {
        if(Auth::user()->role == 'blogger'){
            return redirect()->route('dashboard');
        }
        $request->validate([
            'name' => 'required|string',
        ]);
        $categories = Category::create([
            'name' => $request->name,
        ]);
        if($categories){
            return redirect()->route('categories')->with('success','Category Successfully Added!');
        }
     }

    //  Delete Category
    public function destroyCategory($id){
        if(Auth::user()->role == 'blogger'){
            return redirect()->route('dashboard');
        }
        $category = Category::find($id);
        $category->delete();
        return redirect()->route('categories')->with('success','Post Successfully Deleted!');
    }
     // Show allPostsPage form
     public function allPostsPage()
     {
        if(Auth::user()->role == "blogger"){
            $posts = Post::where('user_id', Auth::user()->id)->get();
            return view('blogger/allposts',compact('posts'));
        }else{
            $posts = Post::all();
            return view('admin/allposts',compact('posts'));
        }
     }
     // Show deletePostPage form
     public function deletePostPage()
     {
        if(Auth::user()->role == 'blogger'){
            return redirect()->route('dashboard');
        }
         return view('admin/deletebyid');
     }
     // Show updatePostPage form
     public function updatePostPage()
     {  
        if(Auth::user()->role == "blogger"){
            return view('blogger/updatepost');
        }else{
            return view('admin/updatepost');
        }
     }
     // Show Upate post by Id form
     public function updateById()
     {
        if(Auth::user()->role == 'blogger'){
            $categories = Category::all();
            return view('blogger/updateById',compact('categories'));
        }else{
            $categories = Category::all();
            return view('admin/updateById',compact('categories'));
        }
     }
 
     // Show viewPostPage form
     public function viewPostPage($id)
     {

        $post = Post::with('user','comment.user','comment.replies.user')->find($id);
        if(Auth::user()->role == "blogger"){
            return view('blogger/viewpost', compact('post'));
        }else{
            return view('admin/viewpost', compact('post'));
        }

        // if(Auth::user()->role == "blogger"){
        //     return view('blogger/viewpost');
        // }else{
        //     return view('admin/viewpost');
        // }
     }
 
     // Handle registration form submission
     public function register(Request $request)
     {
         // Validate the form data
         $request->validate([
             'name' => 'required|string|max:255',
             'email' => 'required|string|email|max:255|unique:users',
             'password' => 'required|string|min:8|confirmed',
             'role' => 'string',
             'profile' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
         ]);
         
         if ($request->hasFile('profile')) {
            $image = $request->file('profile');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('img'), $imageName); // Move the image to public/img directory
            $imagePath = 'img/' . $imageName; // Relative path to store in the database
        }

         // Create a new user record
         $user = User::create([
             'name' => $request->name,
             'email' => $request->email,
             'password' => Hash::make($request->password),
             'profile' => $imagePath,
         ]);
         
         if ($user) {

            $token = Str::random(60);
            EmailVerificationToken::create([
                'user_id' => $user->id,
                'token' => $token,
            ]);
            $this->sendVerificationEmail($user, $token);
            return redirect()->route('loginPage')->with('message', 'Please check your email! we have sent you an email verification link to verify you.');

        } else {
            // Handle registration failure if necessary
            return redirect()->back()->withInput()->withErrors(['error' => 'Registration failed. Please try again.']);
        }
         
     }

     protected function sendVerificationEmail($user, $token)
    {
        $verificationUrl = route('verify.email', ['token' => $token]);

        Mail::send('emails.verify', ['url' => $verificationUrl], function ($message) use ($user) {
            $message->to($user->email);
            $message->subject('Email Verification');
        });
    }


     public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8',
        ]);
        if (Auth::attempt($credentials)) {
          
            $user = User::where('email', $request->email)->first();
            if ($user && $user->email_verified_at != null) {
                if(Auth::user()->role == 'user'){
                    // return redirect()->intende;
                    return redirect()->route('homepage');
                }else{
                    if(Auth::user()->role == 'blogger'){
                        return redirect()->route('dashboard');
                    }
                    return redirect()->route('admindashboard');
                }
            } else {
                Auth::logout();
                return back()->withErrors([
                    'error' => 'Your email address is not verified.',
                ]);
            }
        } else {
            return back()->withErrors([
                'error' => 'The provided credentials do not match our records.',
            ]);
        }

    }


    // Logout method
    public function logout(Request $request)
    {
        if(!Auth::user()->role == 'user'){
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect('homepage');
        }else{
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect('/');
        }
    }

}
