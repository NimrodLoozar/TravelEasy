<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Invoice;
use App\Models\Booking;

class InvoiceFactory extends Factory
{
    protected $model = Invoice::class;

    public function definition()
    {
        $amountExclVat = $this->faker->randomFloat(2, 50, 1000);
        $vat = $amountExclVat * 0.21; // 21% BTW
        $amountInclVat = $amountExclVat + $vat;

        return [
            'booking_id' => Booking::factory(),
            'invoice_number' => strtoupper($this->faker->unique()->bothify('INV###??')),
            'invoice_date' => $this->faker->date,
            'amount_excl_vat' => $amountExclVat,
            'vat' => $vat,
            'amount_incl_vat' => $amountInclVat,
            'invoice_status' => $this->faker->randomElement(['Paid', 'Unpaid', 'Overdue']),
            'is_active' => $this->faker->boolean,
            'note' => $this->faker->optional()->text(100),
        ];
    }
}
