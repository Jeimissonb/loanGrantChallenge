<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

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

Route::get('/', [UserController::class, 'Index'])->name('Page.index');

Route::post('/login', [LoginController::class, 'SingIn'])->name('LoginController.SingIn');

Route::get('/dados', [HomeController::class, 'Home'])->name('Page.Dados')->middleware('auth');

Route::get('/logout', [LoginController::class, 'SingOut'])->name('LoginController.SingOut');

//->middleware('auth');
//Route::post('/login', [UserController::class, 'login'])->middleware('auth');

//Route::get('/logout', [LoginController::class, 'SingOut']);

// Route::get('/logout', function () {
//     Auth::logout();
//     return redirect()->action('App\Http\Controllers\UserController@index');;
// });

//Route::group(['middleware' => ['auth']], function () {
//Route::post('/login', [UserController::class, 'login'])->name('login');

// Route::get('/logout', function () {
//     Auth::logout();
//     return redirect()->action('/');
// });
//Route::get('/', [UserController::class, 'index'])->name('home');
//Route::get('/', [LoginController::class, 'singOut'])->name('home.login');
//Route::get('/logout', [LoginController::class, 'singOut'])->name('home.login');
//});

//Route::post('/login', [UserController::class, 'login'])->name('login');

Route::get('/sendMail', function () {
    Mail::send('mail.emailModel', ['curso' => 'Eloquent'], function ($m) {
        $m->from('fernandodanatas1943@gmail.com', 'Fernando');
        $m->subject('Meu email de teste');
        $m->to('dididantas000@gmail.com');
    });
});
