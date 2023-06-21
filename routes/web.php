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

Route::group(['as' => 'boards', 'prefix' => 'boards', 'middleware'=>'auth'], static function () {
    Route::get('/',[BoardController::class,'index'])->name('.index');
    Route::get('/create-page',[BoardController::class,'create_page'])->name('.create_page');
    Route::post('/store',[BoardController::class,'store'])->name('.store');
    Route::get('/{board}', [BoardController::class, 'detail_page'])->name('.detail_page');
    Route::get('/{board}/edit-page',[BoardController::class,'edit_page'])->name('.edit_page');
    Route::patch('/{board}}',[BoardController::class,'update'])->name('.update');
    Route::delete('/{board}', [BoardController::class, 'destroy'])->name('.destroy');
});


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['as'=>'comments', 'prefix' => 'comments', 'middleware'=>'auth'], static function(){
    Route::post('/store/{board}', [CommentController::class, 'store'])->name('.store');
    Route::delete('/{comment}', [CommentController::class, 'destroy'])->name('.destroy');
});
