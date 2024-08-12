<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;


// UserController
Route::middleware(['ok-user','CheckRole:blogger'])->group(function(){

    Route::controller(UserController::class)->group(function(){

        Route::prefix('/blogger')->group(function(){

            Route::get('/dashboard','dashboardPage')->name('dashboard');
            Route::get('/addpost','addPostPage')->name('addpost');
            Route::get('/update','updatePostPage')->name('update');
            Route::get('/allposts','allPostsPage')->name('allposts');
            Route::get('/viewpost/{id}','viewPostPage')->name('viewpost');
            Route::get('/updateById','updateById')->name('updateById');

        }); 

    });

    Route::get('/markasread/{id}',[HomeController::class,'markasread'])->name('markasread');
});