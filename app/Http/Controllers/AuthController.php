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
        $user = User::where('email', $request->email)->first();

        if (Hash::check($request->password, $user->password)) {
            return response()->json([
                'token' => $user->createToken(time())->plainTextToken
            ]);
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
