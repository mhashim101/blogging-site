<?php

use App\Http\Middleware\Home;
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
Route::middleware(['ok-user','CheckRole:blogger'])->group(function(){

    Route::controller(UserController::class)->group(function(){

        Route::prefix('/blogger')->group(function(){

            Route::get('/dashboard','dashboardPage')->name('dashboard');
            Route::get('/addpost','addPostPage')->name('addpost');
            Route::get('/update','updatePostPage')->name('update');
            Route::get('/allposts','allPostsPage')->name('allposts');
            Route::get('/viewpost','viewPostPage')->name('viewpost');
            Route::get('/updateById','updateById')->name('updateById');

        }); 

    });
});

Route::middleware(['ok-user','CheckRole:admin'])->group(function(){

    //User Controller
    Route::controller(UserController::class)->group(function(){

            Route::prefix('/admin')->group(function(){

                Route::get('/addpost','addPostPage')->name('adminaddpost');
                Route::get('/update','updatePostPage')->name('adminupdate');
                Route::get('/allposts','allPostsPage')->name('adminallposts');
                Route::get('/viewpost','viewPostPage')->name('adminviewpost');
                Route::get('/updateById','updateById')->name('adminupdateById');
                Route::get('/dashboard','dashboardPage')->name('admindashboard');
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
    });

    //Post Controller
    Route::controller(PostController::class)->group(function(){
        
        Route::get('/showPostById','showPostById')->name('showPostById');
        Route::get('/showPostOnDelete','showPostOnDelete')->name('showPostOnDelete');
        Route::delete('/destroyById','destroyById')->name('destroyById');
        Route::post('/search','search')->name('search');
        Route::resource('post', PostController::class);
        
    });

    // Like Controller
    Route::controller(LikeController::class)->group(function(){

        Route::post('/likePost/{id}','likePost')->name('like');
        Route::delete('/unlikePost/{id}','unlikePost')->name('dislike');

    });

    // Comment Controller
    Route::controller(CommentController::class)->group(function(){
        Route::post('/comment','store')->name('storeComment');
        Route::post('/update','update')->name('updateComment');
        Route::get('/delete/{id}','destroy')->name('deleteComment');
        
    });
    Route::get('/admin/showComments',[CommentController::class,'showComments'])->name('showComments');


    // ReplyController

    Route::controller(ReplyController::class)->group(function(){

        Route::post('/reply','storeReply')->name('storeReply');
        Route::get('/admin/showreply/{id}','show')->name('showCommentReplies');

    });

});



//Comment Controller






// Route::middleware([Home::class])->group(function(){

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
        Route::get('/allblogs','allblogs')->name('allblogs');
        Route::get('/bloggers','bloggers')->name('bloggers');

    });

// });


// GoogleController
Route::controller(GoogleController::class)->group(function(){

    Route::get('auth/google','redirectToGoogle')->name('auth.google');
    Route::get('auth/google/callback','handleGoogleCallback')->name('auth.google.callback');

});