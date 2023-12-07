<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    protected function create(Request $request)
    {
        // Validation des données du formulaire
        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'pseudo' => 'required',
            'birthday' => 'required',
            'status' => 'required|numeric',
        ]);

        // Création d'un nouvel utilisateur
        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'pseudo' => $validatedData['pseudo'],
            'birthday' => $validatedData['birthday'],
            'status' => (int)$validatedData['status'],
        ]);

        if ($user) {
            // Utilisateur créé avec succès, retourne un JSON indiquant le succès
            return response()->json(['message' => 'Utilisateur créé avec succès.'], 200);
        } else {
            // Utilisateur non créé, retourne un JSON avec un message d'erreur
            return response()->json(['message' => 'Erreur lors de la création du compte. Veuillez réessayer.'], 500);
        }
    }
}
