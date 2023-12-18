<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\PlaceController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\PasswordChangeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RateController;

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


Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

Route::put('/user/profile/update', [ProfileController::class, 'updateUserProfile']);

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

// Reset Email
Route::post('/send-reset-email', [ResetPasswordController::class, 'sendResetEmail'])->name('password.reset');

// formulaire de réinitialisation de mot de passe
Route::get('reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])
    ->name('password.reset');
Route::get('reset-password/token/{token}', [ResetPasswordController::class, 'getToken']);

// réinitialisation du mot de passe
Route::post('reset-password', [ResetPasswordController::class, 'resetPassword'])
    ->name('password.update');

// Profil utilisateur
Route::get('/user/profile', [ProfileController::class, 'getUserProfile']);

// Toutes les routes de places
Route::resource('/places', PlaceController::class);

// Ajout d'un avis
Route::post('/rates', [RateController::class, 'addRating'])->name('rates.create');

// Supprimer un avis
Route::delete('/rates/{rate}', [RateController::class, 'destroy'])->name('rates.destroy');
