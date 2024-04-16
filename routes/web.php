<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('/dashboard/dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::resource('dashboard', PostController::class)
->only(['index', 'store', 'edit', 'update', 'destroy'])
->middleware(['auth','verified']);

Route::resource('post', PostController::class)
->only(['index', 'store', 'edit', 'update', 'destroy'])
->middleware(['auth','verified']);
Route::get('post/connUserPosts', [PostController::class, 'connUserPosts'])->name('post.connUserPosts');



require __DIR__.'/auth.php';
