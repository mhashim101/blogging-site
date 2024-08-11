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

   

     
     public function dashboardPage()
     {  
        if(Auth::user()->role == "blogger"){
            return view('blogger/dashboard');
        }else{
            return view('admin/dashboard');
        }
     }

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

     public function addPostPage()
     {  
         $categories = Category::all();
        if(Auth::user()->role == 'blogger'){
            return view('blogger/addpost',compact('categories'));
         }else{
            return view('admin/addpost',compact('categories'));
         }
     }

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


    public function destroyCategory($id){
        if(Auth::user()->role == 'blogger'){
            return redirect()->route('dashboard');
        }
        $category = Category::find($id);
        $category->delete();
        return redirect()->route('categories')->with('success','Post Successfully Deleted!');
    }

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
 
     public function deletePostPage()
     {
        if(Auth::user()->role == 'blogger'){
            return redirect()->route('dashboard');
        }
         return view('admin/deletebyid');
     }

     public function updatePostPage()
     {  
        if(Auth::user()->role == "blogger"){
            return view('blogger/updatepost');
        }else{
            return view('admin/updatepost');
        }
     }

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
 

     public function viewPostPage($id)
     {

        $post = Post::with('user','comment.user','comment.replies.user')->find($id);
        if(Auth::user()->role == "blogger"){
            return view('blogger/viewpost', compact('post'));
        }else{
            return view('admin/viewpost', compact('post'));
        }

     }
 

     public function register(Request $request)
     {
 
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
            $image->move(public_path('img'), $imageName); 
            $imagePath = 'img/' . $imageName; 
        }

   
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
