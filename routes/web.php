<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;

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

Route::get('/', [UserController::class, 'index'])->name('home.login');

Route::post('/login', [UserController::class, 'login'])->name('login');

Route::get('/logout', function () {
    Auth::logout();
    return redirect()->action('App\Http\Controllers\UserController@index');;
});

// Route::group(['middleware' => ['auth']], function() {
//     Route::post('/login', [UserController::class, 'login'])->name('login');

//     Route::get('/logout',function(){
//         Auth::logout();
//         return redirect()->action('/');
//     });


// });
