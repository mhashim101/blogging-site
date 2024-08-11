<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GoogleController;

// GoogleController
Route::controller(GoogleController::class)->group(function(){

    Route::get('auth/google','redirectToGoogle')->name('auth.google');
    Route::get('auth/google/callback','handleGoogleCallback')->name('auth.google.callback');

});