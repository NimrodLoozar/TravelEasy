<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Task;
use App\Models\Booking;

class Invoice extends Model
{
    use HasFactory;

    protected $table = 'invoices';

    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = [
        'booking_id',
        'number',
        'date',
        'amount_excl_vat',
        'vat',
        'amount_incl_vat',
        'status',
        'note',
    ];

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($invoice) {
            $lastInvoice = Invoice::latest('id')->first();
            $invoice->number = $lastInvoice ? str_pad($lastInvoice->number + 1, 6, '0', STR_PAD_LEFT) : '000001';
        });
    }

}
