<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Customer extends Model
{
    use HasFactory;

    protected $table = 'customers';

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
        return $this->hasOne(Contact::class);
    }

    public static function getJoinedData()
    {
        return DB::table('customers')
            ->join('people', 'customers.person_id', '=', 'people.id')
            ->join('contacts', 'customers.id', '=', 'contacts.customer_id')
            ->select(
                'customers.*',
                'people.first_name',
                'people.middle_name',
                'people.last_name',
                'contacts.email'
            );
    }
}
