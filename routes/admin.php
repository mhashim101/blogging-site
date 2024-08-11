<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

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
});