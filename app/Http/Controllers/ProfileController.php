<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Log;

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
        Log::info('Received PUT request at updateUserProfile method');

        try {
            // Récupérer l'utilisateur actuellement authentifié
            $user = User::find(Auth::id());

            if (!$user) {
                return response()->json(['error' => 'Utilisateur non trouvé'], 404);
            }

            // Validation des données du formulaire
            $request->validate([
                'firstname' => 'required',
                'lastname' => 'required',
                'email' => 'required|email',
                'birthday' => 'nullable|date_format:Y-m-d',
                'pseudo' => 'nullable',
            ]);

            // Mettre à jour les informations du profil
            $user->firstname = $request->input('firstname');
            $user->lastname = $request->input('lastname');
            $user->email = $request->input('email');
            $user->birthday = $request->input('birthday');
            $user->pseudo = $request->input('pseudo');

            $user->save();

            return response()->json(['message' => 'Profil utilisateur mis à jour avec succès']);
        } catch (\Exception $e) {
            Log::error('Error updating user profile: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

}
