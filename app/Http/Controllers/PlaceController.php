<?php

namespace App\Http\Controllers;

use App\Models\Place;
use App\Models\Rate;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PlaceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Place $place)
    {
        $places=Place::getAll();
        foreach ($places as $place) {
            $place->image = asset('storage/images/' . $place->image);
        }
        $categories=Category::getAll();

        $responseDate = [
            "places" => $places,
            "categories" => $categories,
        ];

        return response()->json($responseDate);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories=Category::select('categories.*')
            ->get();
        return response()->json($categories);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // $request->validate([
        //     'name' => 'required|string|max:255',
        //     'address' => 'required|string|max:255',
        //     'city' => 'required|string|max:255',
        //     'zip_code' => 'required|int|max:10',
        //     'description' => 'required|string',
        //     'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
        // ]);

        $fileName = time() . '.' . $request->image->getClientOriginalName();
        $path = $request->image->storeAs('public/images', $fileName);

        if ($request->isMethod('POST')) {
            $data = $request->all();
            $place = new Place;
            $place->name = $data['name'];
            $place->address = $data['address'];
            $place->city = $data['city'];
            $place->zip_code = $data['zip_code'];
            $place->description = $data['description'];
            $place->image = $fileName;
            $place->user_id = $data['user_id'];
            $place->save();

            if (isset($data['categories']) && is_array($data['categories'])) {
            $place->categories()->attach($data['categories']);
            }

            return response()->json(['message'=>'Création du lieu réussie']);
        }
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

        // Récupération des catégories
        $place = Place::select('places.*')->where('id', $place['id'])->with('categories')->get();

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
    public function destroy(Place $place)
    {
        $result= $place->delete();
        if ($result) {
            return ['message' => 'Lieu supprimé avec succès'];
        } else {
            return ['message' => 'Erreur dans la suppression du lieu'];
        }
    }
}
