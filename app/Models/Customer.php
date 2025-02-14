<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'person_id',
        'relation_number',
        'is_active',
        'note',
    ];

    public function person()
    {
        return $this->belongsTo(Person::class);
    }

    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }
}
