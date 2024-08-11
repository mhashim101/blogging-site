<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

// UserController
Route::controller(UserController::class)->group(function(){

    Route::post('/registerUser','register')->name('registerUser');
    Route::post('/loginMatch','login')->name('loginMatch');
    Route::get('/logoutUser','logout')->name('logoutUser');
    Route::get('/postbycategory/{name}','postByCategory')->name('postByCategory');

});

//HomeController
Route::controller(HomeController::class)->group(function(){
    Route::get('/','showLoginForm')->name('loginPage');
    Route::get('/register','showRegistrationForm')->name('registerPage');
    Route::get('/homepage','showHomePage')->name('homepage');
    Route::get('/bloggers','bloggers')->name('bloggers');
    Route::get('/blogposts/{id}','showBlogPosts')->name('blogposts');
    Route::get('/allblogs','allblogs')->name('allblogs');
    Route::post('/search','search')->name('search');
    Route::get('/bloggerposts/{id}','bloggerposts')->name('bloggerposts');

});