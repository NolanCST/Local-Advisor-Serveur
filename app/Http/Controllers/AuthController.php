<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    public function login(Request $request)
    {
        // Validation des données du formulaire de connexion
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Tentative d'authentification de l'utilisateur
        if (Auth::attempt($credentials)) {
            // Authentification réussie, retourne un JSON indiquant le succès
            return response()->json(['message' => 'Authentification réussie.'], 200);
        }

        // En cas d'échec de l'authentification, retourne un JSON avec un message d'erreur
        return response()->json(['message' => 'Email ou mot de passe incorrect.'], 401);
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
