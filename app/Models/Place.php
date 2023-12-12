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
            ->get();
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }
}
