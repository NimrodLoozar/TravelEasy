<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Task;

// use App\Models\Patient;
// use App\Models\Treatment;

class Invoice extends Model
{
    use HasFactory;

    protected $table = 'invoices';

    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = [
        // 'patient_id',
        // 'treatment_id',
        // 'number',
        // 'date',
        // 'amount',
        // 'status',
    ];

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    // public function patient()
    // {
    //     return $this->belongsTo(Patient::class);
    // }

    // public function treatment()
    // {
    //     return $this->belongsTo(Treatment::class);
    // }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($invoice) {
            $lastInvoice = Invoice::latest('id')->first();
            $invoice->number = $lastInvoice ? str_pad($lastInvoice->number + 1, 6, '0', STR_PAD_LEFT) : '000001';
        });
    }

}
