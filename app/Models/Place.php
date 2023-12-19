<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Place extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'address','zip_code', 'city', 'description', 'image', 'coordinates', 'user_id', ];

    public static function getAll() {
        return Place::select('places.*')
            ->with('categories')
            ->leftJoin('rates', 'places.id', '=', 'rates.place_id')
            ->selectRaw('places.*, COUNT(rates.id) as total_rates, ROUND(AVG(rates.rate), 1) as average_rating')
            ->groupBy('places.id')
            ->get();
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }
}
