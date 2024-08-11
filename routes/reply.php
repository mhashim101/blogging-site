<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReplyController;

// ReplyController
Route::middleware(['ok-user'])->group(function(){

    Route::controller(ReplyController::class)->group(function(){

        Route::post('/reply','storeReply')->name('storeReply');
        Route::get('/admin/showreply/{id}','show')->name('showCommentReplies');

    });
    
});