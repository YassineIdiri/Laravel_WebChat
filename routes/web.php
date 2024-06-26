<?php

use App\Events\chatNotif;
use App\Http\Middleware\IsLogged;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Index\IndexController;
use App\Http\Controllers\Index\SearchController;
use App\Http\Controllers\Index\ConnexionController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\User\EditUserController;
use App\Http\Controllers\Article\StoreController;
use App\Http\Controllers\Article\ArticleController;
use App\Http\Controllers\Article\EditArticleController;
use App\Http\Controllers\Article\EditImageArticleController;
use App\Http\Controllers\Comment\CommentController;
use App\Http\Controllers\Comment\LikeController;
use App\Http\Controllers\MapController;
use App\Http\Controllers\Message\MessageController;
use App\Http\Controllers\Message\EditMessageController;
use App\Http\Controllers\Order\CartController;
use App\Http\Controllers\Order\CheckoutController;
use App\Http\Controllers\Order\MailController;
use App\Http\Controllers\PHPMailerController;

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

Route::prefix('/') -> controller(ConnexionController::class) -> group(function () {

    Route::post('login',  'loginSubmit')->name('loginSubmit');
    Route::get('logout','logout')->name('logout');
    Route::post('signup', 'signupSubmit')->name('signupSubmit');
    Route::get('activate/{ref}','signupActivate')->name('activate');
});

Route::prefix('/') -> controller(IndexController::class) -> group(function () {
    Route::get('', 'index')->name('index');  
});

Route::prefix('/message') -> controller(MessageController::class) ->  name("message") -> group(function () {

    Route::get('/', 'index')->name('.index')-> middleware(IsLogged::class);
    Route::get('/{user}', 'conversation')->name('.conversation')-> middleware(IsLogged::class);
});

Route::prefix('/message') -> controller(EditMessageController::class) ->  name("message") -> group(function () {

    Route::post('/submit', 'addMessage')->name('.submit')-> middleware(IsLogged::class);
    Route::get('/edit/{id}', 'editMessage')->name('.edit')-> middleware(IsLogged::class);
    Route::post('/edit', 'submitEditMessage')->name('.submitEdit')-> middleware(IsLogged::class);
    Route::delete('/delete/{id}', 'deleteMessage')->name('.delete')-> middleware(IsLogged::class);
});


Route::prefix('/user') -> controller(UserController::class) ->  name("user") -> group(function () {
    Route::get('/settings', 'setting')->name('.settings') -> middleware(IsLogged::class);
    Route::post('/edit', 'edit')->name('.edit') -> middleware(IsLogged::class);
    Route::post('/delete',  'delete')->name('.delete') -> middleware(IsLogged::class);
});




















