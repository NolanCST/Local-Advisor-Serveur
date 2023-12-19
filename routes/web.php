<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ResetPasswordController;


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

Route::get('/', function () {
    return view('welcome');
});
// Reset Email
Route::post('/send-reset-email', [ResetPasswordController::class, 'ResetPasswordController'])->name('ResetPasswordController');

Route::get('reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])
    ->name('password.reset');
