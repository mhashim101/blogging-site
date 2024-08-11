<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;

 //Post Controller
 Route::middleware(['ok-user'])->group(function(){

    Route::controller(PostController::class)->group(function(){
            
        Route::get('/showPostById','showPostById')->name('showPostById');
        Route::get('/showPostOnDelete','showPostOnDelete')->name('showPostOnDelete');
        Route::delete('/destroyById','destroyById')->name('destroyById');
        Route::resource('post', PostController::class);
        
    });

});
// Route::post('/search',[PostController::class,'search'])->name('search');