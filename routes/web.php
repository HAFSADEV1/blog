<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostCommentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PostTagController;
use App\Post;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', function () {
    return view('welcome');
});
Route::get('/posts/archive', [PostController::class, 'archive']);
Route::get('/secret', [HomeController::class, 'secret'])->name('secret')->middleware('can:secret.page');

Route::get('/posts/all', [PostController::class, 'all']);
Route::delete('/posts/{id}/forcedelete', [PostController::class, 'forcedelete']);
Route::patch('/posts/{id}/restore', [PostController::class, 'restore']);

// Route::resource('user', 'UserController');

Route::resource('posts.comments', PostCommentController::class)->only(['store']);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resource('/posts', PostController::class);
Route::get('/posts/tags/{id}', [PostTagController::class, 'index'])->name('posts.tag.index');
