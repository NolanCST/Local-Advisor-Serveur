<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rate extends Model
{
    use HasFactory;

    protected $fillable = ['image', 'rate', 'review', 'user_id', 'place_id'];    

    public function user() {
        return $this->beLongsTo('App\Models\User', 'user_id');
    }
}
