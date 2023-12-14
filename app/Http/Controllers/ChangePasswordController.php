<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;


class PasswordChangeController extends Controller
{
    public function changePassword(Request $request)
    {
        $request->validate([
            'newPassword' => 'required|min:6',
        ]);

        $user = Auth::user(); // Récupère l'utilisateur authentifié

        $userModel = User::find($user->id); // instance de modèle User

        $userModel->changePassword($request->newPassword);

        return response()->json(['success' => true, 'message' => 'Mot de passe changé avec succès']);
    }
}
