<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        // Ne retourne plus la vue, mais un JSON indiquant l'erreur
        return response()->json(['message' => 'Cette action n\'est pas autorisée.'], 403);
    }

    public function showRegistrationForm()
    {
        // Ne retourne plus la vue, mais un JSON indiquant l'erreur
        return response()->json(['message' => 'Cette action n\'est pas autorisée.'], 403);
    }

    public function Login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $token = Auth::user()->createToken('authToken')->plainTextToken;
            return ['token' => $token];
        }
    }

    public function logout(Request $request)
    {
        Auth::logout(); // Déconnexion de l'utilisateur

        $request->session()->invalidate(); // Effacement de la session

        $request->session()->regenerateToken(); // Régénération du token de session

        // Retourne un JSON indiquant le succès de la déconnexion
        return response()->json(['message' => 'Déconnexion réussie.'], 200);
    }
}
