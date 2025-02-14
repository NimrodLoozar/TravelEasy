<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReizenOverzicht extends Model
{
    protected $table = 'departures'; // Gebruik de 'departures' tabel

    protected $fillable = [
        'country',
        'airport',
        'is_active',
        'note',
    ];
}