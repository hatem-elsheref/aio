<?php

use Hatem\Aio\Route;
use App\Http\Controllers\HomeController;

Route::get('/', [HomeController::class, 'index']);
// Route::get('/posts/{post}', [HomeController::class, 'posts']);
// Route::get('/about', [HomeController::class, 'about']);
// Route::get('/contact', [HomeController::class, 'contact']);
// Route::get('/login', [HomeController::class, 'login']);
// Route::get('/register', [HomeController::class, 'register']);