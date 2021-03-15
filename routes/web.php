<?php

use App\Http\Controllers\Blog\PostsController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TagController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WelcomeController;

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

Auth::routes();

Route::get('/', [WelcomeController::class, "index"])->name("welcome");
Route::get("blog/posts/{post}", [PostsController::class, "show"])->name("blog.show");
Route::get('blog/categories/{category}', [PostsController::class, "category"])->name("blog.category");
Route::get('blog/tags/{tag}', [PostsController::class, "tag"])->name("blog.tag");

Route::middleware(['auth'])->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::resource('posts', PostController::class);
    Route::resource('categories', CategoriesController::class);
    Route::resource('tags', TagController::class);
    Route::get('trashed-posts', [PostController::class, "trashed"])->name("posts.trashed");
    Route::get('restore-posts/{id}', [PostController::class, "restore"])->name("posts.restore");
    Route::delete('destroy-posts/{id}', [PostController::class, "permanentDelete"])->name("posts.permanentDelete");
    Route::get("users", [UserController::class, "index"])->name("users.index");
    Route::Put("users/{user}/make-admin", [UserController::class, "makeAdmin"])->name("users.admin");
    Route::get("users/profile", [UserController::class, "edit"])->name("users.edit-profile");
    Route::put("users/{user}", [UserController::class, "update"])->name("users.update-profile");
});
