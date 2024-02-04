<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PusherController;
use App\Http\Controllers\QueueController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [HomeController::class, 'index']);
Route::get('/kiosk', [HomeController::class, 'kiosk']);

Route::get('/login', [AuthController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'authenticate']);
Route::post('/logout', [AuthController::class, 'logout']);

Route::get('/admin', [HomeController::class, 'admin'])->middleware('auth');

Route::post('/add-queue', [QueueController::class, 'addQueue']);
Route::post('/next-queue', [QueueController::class, 'nextQueue']);
Route::post('/prev-queue', [QueueController::class, 'prevQueue']);
Route::get('/get-queue', [QueueController::class, 'getQueue']);
