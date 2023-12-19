<?php

namespace App\Http\Controllers;

use App\Models\Rate;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class RateController extends Controller
{

    public function update(Request $request, Rate $rate)
    {
        $request->validate([
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'rate' => 'required|min:1|max:5',
            'review' => 'max:1000',
        ]);

        $rate->rate = $request->rate;
        $rate->review = $request->review;

        $rate->save();

        return response()->json(['message'=>'Modification de l\'avis réussie']);
    }

    public function destroy(Rate $rate)
    {
        Storage::delete('public/images/'.$rate->image);
        $result = $rate->delete();
        if ($result) {
            return ['message' => 'Avis supprimé avec succès'];
        } else {
            return ['message' => 'Errer dans la suppression de l\'avis'];
        }
    }

    public function addRating (Request $request) {
        
        $fileName = time() . '.' . $request->image->getClientOriginalName();
        $path = $request->image->storeAs('public/images', $fileName);

        $data = $request->all();

        $rating = new Rate;
        $rating->user_id = $request->user()->id;
        $rating->place_id = $data['place_id'];
        $rating->image = $fileName;
        $rating->review = $data['review'];
        $rating->rate = $data['rate'];
        $rating->save();

        return response()->json(['message'=>'Votre avis a bien ete cree']);
    }

}
