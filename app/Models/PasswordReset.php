<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class PasswordReset extends Model
{
    use HasFactory;

    protected $fillable = ['email', 'token'];
    protected $table = 'password_reset_tokens';
    public $timestamps = false; // pas de timestamps
}
