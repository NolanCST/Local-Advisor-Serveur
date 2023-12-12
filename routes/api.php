<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\PlaceController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\PasswordChangeController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('dashboard', [AuthController:: class, 'dashboard'])
->middleware( 'auth: sanctum');

// Authentification
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/tokens/create', [AuthController::class, 'createToken']);

// Deconnexion
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Registration
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'create'])->name('register');

// Accueil
Route::get('/place', [PlaceController::class, 'index']);

// Reset Email
Route::post('/send-reset-email', [ResetPasswordController::class, 'ResetPasswordController'])->name('ResetPasswordController');

// changement mot de passe
Route::post('/passwordChange', [PasswordChangeController::class, 'changePassword']);
