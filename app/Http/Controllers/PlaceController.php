<?php

namespace App\Http\Controllers;

use App\Models\Place;
use Illuminate\Http\Request;

class PlaceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $places=Place::getAll();
        return response()->json($places);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
      //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'adress' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'zip_code' => 'required|int|max:10',
            'categories' => 'required|string|max:255',
            'description' => 'required|string',
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
        ]);

        $place= new Place;
        $place->name=$request->input('name');
        $place->name=$request->input('adress');
        $place->name=$request->input('city');
        $place->name=$request->input('zip_code');
        $place->name=$request->input('categories');
        $place->name=$request->input('description');
        $place->file_path=$request->file('image')->store('places');
        $place->save();
        return response()->json(['message'=>'Création réussie']);



    }

    /**
     * Display the specified resource.
     */
    public function show(Place $place)
    {
        $places = Place::all();
        return response()->json($place);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Place $place)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Place $place)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $place = Place::find($id);
    
        if (!$place) {
            return response()->json(['error' => 'ntm coté serveur'], 404);
        }
    
        $place->delete();
        return response()->json(['message' => 'Lieu supprimé avec succès']);
    }
}
