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
            'invoice_number' => $this->faker->numberBetween(100000, 999999),
            'invoice_date' => $this->faker->dateTimeBetween('-1 month', 'now')->format('Y-m-d'),
            'amount_excl_vat' => $this->faker->randomFloat(2, 100, 1000),
            'vat' => $this->faker->randomFloat(2, 10, 100),
            'amount_incl_vat' => $this->faker->randomFloat(2, 110, 1100),
            'status' => $this->faker->randomElement(['betaald', 'onbetaald', 'in behandeling']),
            'created_at' => now(),
            'updated_at' => now()
        ];
    }
}
