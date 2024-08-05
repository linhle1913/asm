<?php

use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\AuthorController\AuthorController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FrontController\AuthController;
use App\Http\Controllers\FrontController\FrontController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\TagController;
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

Route::get('/', [FrontController::class, 'index'])->name('home');
Route::get('/detail/{id}/{slug?}', [FrontController::class, 'detail'])->name('detail');
Route::get('/list/{id}/{slug?}', [FrontController::class, 'list'])->name('list');
Route::get('/search', [FrontController::class, 'search'])->name('search');
Route::post('/comment{id}', [CommentController::class, 'store'])->name('comment');


Route::group(['prefix' => 'account'],function(){
    Route::group(['middleware' => 'guest'], function(){
        Route::get('register', [AuthController::class, 'register'])->name('account.register');
        Route::post('register', [AuthController::class, 'processRegister'])->name('account.processRegister');
        Route::get('login', [AuthController::class, 'login'])->name('account.login');
        Route::post('login', [AuthController::class, 'authenticate'])->name('account.authenticate');
        Route::get('forgot_password', [AuthController::class, 'forgot'])->name('account.forgot');
        Route::post('forgot_password', [AuthController::class, 'processForgot'])->name('account.processForgot');
        Route::get('password/reset/{token}', [AuthController::class, 'resetPassword'])->name('account.resetPassword');
        Route::put('password/reset', [AuthController::class, 'processResetPassword'])->name('account.processResetPassword');
    });

    Route::group(['middleware' => 'auth'], function(){
        Route::get('profile', [AuthController::class, 'profile'])->name('account.profile');
        Route::get('logout', [AuthController::class, 'logout'])->name('account.logout');
        Route::group(['prefix' => 'author'], function(){
            Route::group(['prefix' => 'post'], function(){
                Route::get('edit_profile', [AuthController::class, 'editProfile'])->name('author.editProfile');
                Route::put('edit_profile', [AuthController::class, 'processEditProfile'])->name('author.processEditProfile');
                Route::get('list', [PostController::class, 'index'])->name('author.index');
                Route::get('create', [PostController::class, 'create'])->name('author.create');
                Route::post('create', [PostController::class, 'store'])->name('author.store');
                Route::get('edit/{id}', [PostController::class, 'edit'])->name('author.edit');
                Route::put('edit/{id}', [PostController::class, 'update'])->name('author.update');
                Route::delete('post/{post}', [PostController::class, 'destroy'])->name('author.delete');
            });
            Route::post('create', [TagController::class, 'store'])->name('author.tag.store');
        });
    });
});

Route::group(['prefix' => 'admin'], function(){
    Route::group(['middleware' => 'admin_guest'], function(){
        Route::get('login', [AdminController::class, 'login'])->name('admin.login');
        Route::post('login', [AdminController::class, 'authenticate'])->name('admin.authenticate');
    });
    Route::group(['middleware' => 'admin'], function(){
        Route::get('index', [AdminController::class, 'index'])->name('admin.list');
        Route::get('tags', [AdminController::class, 'tags'])->name('admin.tags');
        Route::get('edit/{id}', [AdminController::class, 'edit'])->name('admin.edit');
        Route::put('edit/{id}', [AdminController::class, 'update'])->name('admin.update');
        Route::put('tagedit', [AdminController::class, 'updateTag'])->name('admin.updateTag');
        Route::get('logout', [AdminController::class, 'logout'])->name('admin.logout');
    });
});




