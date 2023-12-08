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
        // return view('rate.edit', compact('rate'));
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

        // return redirect(route('rate.show', $rate['id']));
    }

    public function destroy(Rate $rate)
    {
        Storage::delete('public/images/'.$rate->image);
        $rate->delete();
        // return redirect(route('rate.index'));
    }

    public function addRating (Request $request) {
        if ($request->isMethod('POST')) {
            $data = $request->all();
            if (!Auth::check()) {
                $message = "Vous devez etre connecte pour noter ce lieu";
                echo $message;
                return redirect()->back;
            }

            if (!isset($data['rate'])) {
                $message = "Merci de mettre au moins une etoile pour ce livre";
                echo $message;
                return redirect()->back();
            }

            $ratingCount = Rate::where(['user_id'=>Auth::user()->id, 'place_id'=>$data['place_id']])->count();

            if ($ratingCount>0) {
                $message = "Votre note a deja ete prise en compte pour ce lieu";
                echo $message;
                return redirect()->back();
            } else {
                $rating = new Rate;
                $rating->user_id = Auth::user()->id;
                $rating->book_id = $data['place_id'];
                $rating->review = $data['review'];
                $rating->rate = $data['rate'];
                $rating->status = 1;
                $rating->save();
                $message = "Merci d'avoir note ce lieu !";
                echo $message;
                return redirect()->back();
            }
        }
    }

}
