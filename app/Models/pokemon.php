<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pokemon extends Model
{
    use HasFactory;


    protected $fillable = [
        'poke_name',
        'pokeURL',
        'base_experience',
        'HP'
    ];

    protected $table='pokemon';

}
