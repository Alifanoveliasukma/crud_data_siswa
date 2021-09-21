<?php

use Illuminate\Support\Facades\Route;
use  App\Http\Controllers\SiswaController;
use  App\Http\Controllers\DashboardController;
use  App\Http\Controllers\AuthController;
use GuzzleHttp\Middleware;

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

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/postlogin', [AuthController::class, 'postlogin']);
Route::get('/logout', [AuthController::class, 'logout']);

Route::group(['middleware' => ['auth', 'checkRole:admin']], function () {
    Route::get('/siswa', [SiswaController::class, 'index']);
    Route::post('/siswa/create', [SiswaController::class, 'create']);
    Route::get('/siswa/{id}/edit', [SiswaController::class, 'edit']);
    Route::post('/siswa/{id}/update', [SiswaController::class, 'update']);
    Route::get('/siswa/{id}/delete', [SiswaController::class, 'delete']);
    Route::get('/siswa/{id}/profile', [SiswaController::class, 'profile']);
    Route::post('/siswa/{id}/addnilai', [SiswaController::class, 'addnilai']);
    Route::get('/siswa/{id}/{idmapel}/deletenilai', [SiswaController::class, 'hapus']);
});

Route::group(['middleware' => ['auth', 'checkRole:admin,siswa']], function () {
    Route::get('/dashboard', [DashboardController::class, 'index']);
});

//->Middleware('auth'); membuat middleware habis membuat route
