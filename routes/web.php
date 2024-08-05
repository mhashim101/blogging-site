<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReplyController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\EmailVerificationController;




Route::view('verifyemail','/verifyemail')->name('verifyemail');
// Route::view('emails/notverified','/notverified')->name('notverifyemail');

// EmailVerificationController
Route::get('/emails/verify/{token}', [EmailVerificationController::class, 'verify'])->name('verify.email');




// UserController
Route::middleware(['ok-user'])->group(function(){

    //User Controller
    Route::controller(UserController::class)->group(function(){

        Route::get('/addpost','addPostPage')->name('addpost');
        Route::get('/update','updatePostPage')->name('update');
        Route::get('/allposts','allPostsPage')->name('allposts');
        Route::get('/viewpost','viewPostPage')->name('viewpost');
        Route::get('/updateById','updateById')->name('updateById');
        Route::get('/dashboard','dashboardPage')->name('dashboard');
        Route::get('/allusers','showAllUsersPage')->name('allusers');
        Route::post('/addcategory','addcategory')->name('addcategory');
        Route::get('/deletebyid','deletePostPage')->name('deletebyid');
        Route::get('/categories','showCategoriesPage')->name('categories');
        Route::delete('/deleteUser/{id}','destroyUser')->name('deleteUser');
        Route::get('/destroyCategory/{id}','destroyCategory')->name('destroyCategory');
        Route::get('/categories/addcategory','showAddCategoryPage')->name('addcategorypage');
        Route::post('/updaterole','changeRole')->name('changeRole');
        Route::get('/editPage/{id}','editUserPage')->name('editPage');
        Route::put('/updateUser/{id}','updateUser')->name('updateUser');
    });

    //Comment Controller
});

Route::controller(LikeController::class)->group(function(){
    Route::post('/likePost/{id}','likePost')->name('like');
    Route::delete('/unlikePost/{id}','unlikePost')->name('dislike');
    // Route::get('/like','index')->name('likes');
});


Route::controller(CommentController::class)->group(function(){
    Route::post('/comment','store')->name('storeComment');
    Route::post('/update','update')->name('updateComment');
    Route::get('/delete/{id}','destroy')->name('deleteComment');
    
});
//Comment Controller
Route::get('/showComments',[CommentController::class,'showComments'])->name('showComments');



// ReplyController

Route::controller(ReplyController::class)->group(function(){
    Route::post('/reply','storeReply')->name('storeReply');
    Route::get('/showreply/{id}','show')->name('showCommentReplies');
});


// UserController
Route::controller(UserController::class)->group(function(){

    Route::get('/','showLoginForm')->name('loginPage');
    Route::get('/homepage','showHomePage')->name('homepage');
    Route::get('/blogposts/{id}','showBlogPosts')->name('blogposts');
    Route::get('/register','showRegistrationForm')->name('registerPage');
    Route::post('/registerUser','register')->name('registerUser');
    Route::post('/loginMatch','login')->name('loginMatch');
    Route::get('/logoutUser','logout')->name('logoutUser');
    Route::get('/postbycategory/{name}','postByCategory')->name('postByCategory');

});



// CommentController
// Route::controller(CommentController::class)->group(function(){
//     Route::post('/pushComment','pushComment')->name('pushComment');

//     Route::middleware([ValidUser::class])->group(function(){
//         Route::get('/comments','showComments')->name('comments');
//         Route::delete('/destroyComment/{id}','destroyComment')->name('destroyComment');
//     });
// });






// PostController
Route::middleware('ok-user')->group(function(){

    Route::controller(PostController::class)->group(function(){
        
        Route::get('/showPostById','showPostById')->name('showPostById');
        Route::get('/showPostOnDelete','showPostOnDelete')->name('showPostOnDelete');
        Route::delete('/destroyById','destroyById')->name('destroyById');
        Route::resource('post', PostController::class);
        
    });
    
});
// Route::post('/posts/{post}/like', [PostController::class, 'toggleLike'])->middleware('auth');



// GoogleController
Route::controller(GoogleController::class)->group(function(){

    Route::get('auth/google','redirectToGoogle')->name('auth.google');
    Route::get('auth/google/callback','handleGoogleCallback')->name('auth.google.callback');

});











