<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CommentController;

 // Comment Controller
 Route::middleware(['ok-user'])->group(function(){

    Route::controller(CommentController::class)->group(function(){
        Route::post('/comment','store')->name('storeComment');
        Route::post('/update','update')->name('updateComment');
        Route::get('/delete/{id}','destroy')->name('deleteComment');
        
    });
    Route::get('/admin/showComments',[CommentController::class,'showComments'])->name('showComments');

});