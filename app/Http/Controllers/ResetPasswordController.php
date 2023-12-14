<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

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
}
