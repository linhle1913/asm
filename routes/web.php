<?php

use App\Http\Controllers\AuthorController\AuthorController;
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
Route::get('/detail/{id}', [FrontController::class, 'detail'])->name('detail');
Route::get('/list', [FrontController::class, 'list'])->name('list');

Route::group(['prefix' => 'account'],function(){
    Route::group(['middleware' => 'guest'], function(){
        Route::get('register', [AuthController::class, 'register'])->name('account.register');
        Route::post('register', [AuthController::class, 'processRegister'])->name('account.processRegister');
        Route::get('login', [AuthController::class, 'login'])->name('account.login');
        Route::post('login', [AuthController::class, 'authenticate'])->name('account.authenticate');
    });

    Route::group(['middleware' => 'auth'], function(){
        Route::get('profile', [AuthController::class, 'profile'])->name('account.profile');
        Route::get('logout', [AuthController::class, 'logout'])->name('account.logout');
        Route::group(['prefix' => 'author'], function(){
            Route::group(['prefix' => 'post'], function(){
                Route::get('list', [PostController::class, 'index'])->name('author.index');
                Route::get('create', [PostController::class, 'create'])->name('author.create');
                Route::post('create', [PostController::class, 'store'])->name('author.store');
                Route::get('edit/{id}', [PostController::class, 'edit'])->name('author.edit');
                Route::put('edit/{id}', [PostController::class, 'update'])->name('author.update');
            });
            Route::post('create', [TagController::class, 'store'])->name('author.tag.store');
        });
    });
});




