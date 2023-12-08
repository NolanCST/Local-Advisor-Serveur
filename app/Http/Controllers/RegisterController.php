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
        // $request->validate([
        //     'lastname' => 'required',
        //     'firstname' => 'required',
        //     'email' => 'required|email|unique:users',
        //     'password' => 'required|min:6',
        //     'pseudo' => 'required',
        //     'birthday' => 'required',
        //     'status' => 'required',
        // ]);

        // Création d'un nouvel utilisateur
        $user = User::create([
            'lastname' => $request->lastname,
            'firstname' => $request->firstname,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'pseudo' => $request->pseudo,
            'birthday' => $request->birthday,
            'status' => $request->status,
        ]);

        // if ($user) {
        //     // Utilisateur créé avec succès, retourne un JSON indiquant le succès
        //     return response()->json(['message' => 'Utilisateur créé avec succès.'], 200);
        // } else {
        //     // Utilisateur non créé, retourne un JSON avec un message d'erreur
        //     return response()->json(['message' => 'Erreur lors de la création du compte. Veuillez réessayer.'], 500);
        // }
    }
}
