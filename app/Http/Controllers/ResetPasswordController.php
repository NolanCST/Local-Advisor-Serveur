<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;

class ResetPasswordController extends Controller
{
    public function sendResetEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        // Créer un token de réinitialisation
        $status = Password::broker()->sendResetLink(
            $request->only('email')
        );

        if ($status === Password::RESET_LINK_SENT) {
            return response()->json(['message' => 'Email de réinitialisation envoyé']);
        } else {
            return response()->json(['message' => 'Échec de l\'envoi de l\'email'], 500);
        }
    }
    // Méthode pour récupérer le token
    public function getToken($token)
    {
        $tokenData = [
            'token' => $token,
        ];
        // Retourne les données au format JSON
        return response()->json($tokenData);
    }
    // Réinitialiser le mot de passe
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'token' => 'required',
            'password' => 'required|confirmed|min:6', // Assurez-vous de confirmer le mot de passe
        ]);

        $status = Password::reset($request->only('email', 'password', 'password_confirmation', 'token'), function ($user, $password) {
            $user->password = Hash::make($password);
            $user->save();
        });

        if ($status === Password::PASSWORD_RESET) {
            return response()->json(['message' => 'Mot de passe réinitialisé avec succès']);
        } else {
            return response()->json(['message' => 'Échec de la réinitialisation du mot de passe'], 500);
        }
    }

    public function showResetForm(Request $request, $token)
    {
        // Retourner la vue avec le lien pour réinitialiser le mot de passe
        return view('reset-password-form', ['token' => $token]);
    }


}
