<?php

namespace App\Http\Controllers;

use App\Models\Place;
use App\Models\Rate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        // Recuperation des notes
        $ratings = Rate::with('user')->where('place_id', $place['id'])->orderBy('id', 'desc')->get()->toArray();

        // Faire la moyenne des notes
        $ratingsSum = Rate::where('place_id', $place['id'])->sum('rate');
        $ratingsCount = Rate::where('place_id', $place['id'])->count();
        $avgRating = 0;
        $avgStarRating = 0;
        if ($ratingsCount>0){
            $avgRating = round($ratingsSum/$ratingsCount,2);
            $avgStarRating = round($ratingsSum/$ratingsCount);
        }

        $responseData = [
        'place' => $place,
        'ratings' => $ratings,
        'avgRating' => $avgRating,
        'avgStarRating' => $avgStarRating,
        'ratingsCount' => $ratingsCount,
        ];

        return response()->json($responseData);
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
        // $place = Place::find($id);
    
        // if (!$place) {
        //     return response()->json(['error' => 'ntm coté serveur'], 404);
        // }
    
        // $place->delete();
        // return response()->json(['message' => 'Lieu supprimé avec succès']);
        $result= Place::where('id',$id)->delete();
        if ($result) {
            return ['message' => 'Lieu supprimé avec succès'];
        } else {
            return ['message' => 'Lieu non supprimé'];
        }
    
    }
}
