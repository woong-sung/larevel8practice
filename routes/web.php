<?php

use Illuminate\Support\Facades\Route;
use app\models\board;
use App\Http\Controllers\BoardController;
use App\Http\Controllers\CommentController;

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
    return view('home');
});

Route::group(['as' => 'boards', 'prefix' => 'boards', 'middleware' => 'auth'], static function () {
    Route::get('/', [BoardController::class, 'index'])->name('.index');
    Route::get('/oldest', [BoardController::class, 'oldest'])->name('.oldest');
    Route::get('/create-page', [BoardController::class, 'create_page'])->name('.create_page');
    Route::post('/store', [BoardController::class, 'store'])->name('.store');
    Route::get('/{board}', [BoardController::class, 'detail_page'])->where('board','[0-9]+')->name('.detail_page');
    Route::get('/{board}/edit-page', [BoardController::class, 'edit_page'])->name('.edit_page');
    Route::patch('/{board}', [BoardController::class, 'update'])->name('.update');
    Route::delete('/{board}', [BoardController::class, 'destroy'])->name('.destroy');
    Route::get('/{board}/verify', [BoardController::class, 'verify'])->name('.verify');
    Route::get('/{board}/verify-page', [BoardController::class, 'verify_page'])->name('.verify_page');
    Route::get('/search', [BoardController::class, 'search'])->name('.search');

//    얘는 왜 안될까 라우트 list에는 있지만 404 에러가 나온다!
//    Route::get('/search', [BoardController::class, 'search'])->name('.search');
//    라우터는 위에서 아래로 차례대로 확인한다.
//    Route::get('/{board}', [BoardController::class, 'detail_page'])->name('.detail_page');
//    {board}에 타입을 명시 안해줘서 생긴 에러
//    /{board} 에서 /search가 걸려버림
//    Route::get('/{board}', [BoardController::class, 'detail_page'])->where('board','[0-9]+')->name('.detail_page');
//    처럼 수정하여 타입을 명시해줘서 해결

});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['as' => 'comments', 'prefix' => 'comments', 'middleware' => 'auth'], static function () {
    Route::post('/store/{board}', [CommentController::class, 'store'])->name('.store');
    Route::delete('/{comment}', [CommentController::class, 'destroy'])->name('.destroy');
});
