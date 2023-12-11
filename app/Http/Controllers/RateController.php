<?php

namespace App\Http\Controllers;

use App\Models\Rate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class RateController extends Controller
{

    public function edit(Rate $rate)
    {

    }

    public function update(Request $request, Rate $rate)
    {

        $request->validate([
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'rate' => 'required',
            'review' => 'max:1000',
        ]);

        Storage::delete('public/images/'.$rate->image);

        $fileName = time() . '.' . $request->image->getClientOriginalName();
        $path = $request->image->storeAs('public/images', $fileName);

        $rate->image = $fileName;
        $rate->rate = $request->rate;
        $rate->review = $request->review;

        $rate->save();
    }

    public function destroy(Rate $rate)
    {
        Storage::delete('public/images/'.$rate->image);
        $rate->delete();
    }

    public function addRating (Request $request) {
        if ($request->isMethod('POST')) {
            $data = $request->all();

            $rating = new Rate;
            // $rating->user_id = Auth::user()->id;
            $rating->user_id = $data['user_id'];
            $rating->place_id = $data['place_id'];
            $rating->review = $data['review'];
            $rating->rate = $data['rate'];
            $rating->save();
        }
    }

}
