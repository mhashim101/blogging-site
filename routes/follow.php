<?php

use App\Http\Controllers\FollowController;
use Illuminate\Support\Facades\Route;


Route::controller(FollowController::class)->group(function(){
    Route::put('/follow/{id}','follow')->name('followUser');
    Route::put('/unfollow/{id}','unfollow')->name('unFollowUser');
});