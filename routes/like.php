<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LikeController;

  // Like Controller
Route::middleware(['ok-user'])->group(function(){

    Route::controller(LikeController::class)->group(function(){

        Route::post('/likePost/{id}','likePost')->name('like');
        Route::delete('/unlikePost/{id}','unlikePost')->name('dislike');

    });

});