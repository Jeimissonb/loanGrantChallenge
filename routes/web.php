<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SimulationController;
use App\Mail\newLaravelTips;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;

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

Route::get('/resultado', [HomeController::class, 'Home'])->name('Page.Dados')->middleware('auth');

Route::get('/logout', [LoginController::class, 'SingOut'])->name('LoginController.SingOut');

Route::post('send-mail',  [LoginController::class, 'SendMail'])->name('LoginController.SendMail');

Route::post('forget-info',  [LoginController::class, 'ForgetInfo'])->name('LoginController.ForgetInfo');

//dados routes
Route::post('/send-calculate', [SimulationController::class, 'SendCalculate'])->name('SimulationController.SendCalculate')->middleware('auth');

Route::post('/calculate', [SimulationController::class, 'Calculate'])->name('SimulationController.Calculate')->middleware('auth');
