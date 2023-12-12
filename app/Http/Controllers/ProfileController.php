<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;


class ProfileController extends Controller
{
    // Obtenir les données du profil de l'utilisateur
    public function getUserProfile()
    {
        $user = User::find(Auth::id());

        return response()->json($user);
    }

    // Mettre à jour les données du profil de l'utilisateur
    public function updateUserProfile(Request $request)
    {
        $user = User::find(Auth::id());

        // Validation des données du formulaire
        $request->validate([
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required|email',
            'age' => 'numeric|nullable',
            'pseudo' => 'nullable',
        ]);

        // Mettre à jour les informations du profil
        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        $user->email = $request->email;
        $user->age = $request->age;
        $user->pseudo = $request->pseudo;

        $user->save();

        return response()->json(['message' => 'Profil utilisateur mis à jour avec succès']);
    }
}
