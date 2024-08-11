<?php

use Illuminate\Support\Facades\Route;

Route::view('verifyemail','/verifyemail')->name('verifyemail');

require __DIR__.'/admin.php';
require __DIR__.'/blogger.php';
require __DIR__.'/comments.php';
require __DIR__.'/google.php';
require __DIR__.'/home.php';
require __DIR__.'/like.php';
require __DIR__.'/post.php';
require __DIR__.'/reply.php';
require __DIR__.'/email.php';
require __DIR__.'/follow.php';
