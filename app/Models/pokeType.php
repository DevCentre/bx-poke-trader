<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pokeType extends Model
{
    use HasFactory;



    protected $fillable = [
        'description',
        'type_url'
    ];

    protected $table='poke_type';

}
