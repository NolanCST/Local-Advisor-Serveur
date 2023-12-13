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

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
        ? response()->json(['message' => 'Email de réinitialisation envoyé'])
            : response()->json(['message' => 'Échec de l\'envoi de l\'email'], 500);
    }
    protected function broker()
    {
        return Password::broker();
    }
}
