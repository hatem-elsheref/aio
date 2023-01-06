<?php

use Hatem\Aio\Route;
use App\Http\Controllers\HomeController;

Route::get('/', [HomeController::class, 'index'])->prefix('api')->middleware('auth')->name('home');