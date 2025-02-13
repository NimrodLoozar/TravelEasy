<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Invoice;
use App\Models\Booking;

class InvoiceFactory extends Factory
{

    public function definition()
    {
        $amountExclVat = $this->faker->randomFloat(2, 50, 1000);
        $vat = $amountExclVat * 0.21; // 21% BTW
        $amountInclVat = $amountExclVat + $vat;

        return [
            'booking_id' => Booking::factory(),
            'invoice_number' => self::$invoiceNumber++, // increment invoice number
            'invoice_date' => $this->faker->dateTimeBetween('-1 month', 'now')->format('Y-m-d'),
            'amount_excl_vat' => $amountExclVat,
            'vat' => $vat,
            'amount_incl_vat' => $amountInclVat,
            'status' => $this->faker->randomElement(['betaald', 'onbetaald', 'in behandeling']),
            'created_at' => now(),
            'updated_at' => now()
        ];
    }
}
