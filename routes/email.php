<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmailVerificationController;


Route::get('/emails/verify/{token}', [EmailVerificationController::class, 'verify'])->name('verify.email');