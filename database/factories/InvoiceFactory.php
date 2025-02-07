<?php

namespace Database\Factories;

use App\Models\Booking;
use App\Models\Invoice;
use Illuminate\Database\Eloquent\Factories\Factory;

class InvoiceFactory extends Factory
{
    protected $model = Invoice::class;

    public function definition()
    {
        return [
            'booking_id' => Booking::factory(),
            'invoice_number' => 'INV' . rand(10000, 99999),
            'invoice_date' => $this->faker->date(),
            'amount_excl_vat' => $this->faker->randomFloat(2, 100, 1000),
            'vat' => $this->faker->randomFloat(2, 10, 20),
            'amount_incl_vat' => $this->faker->randomFloat(2, 110, 1020),
            'invoice_status' => 'pending',
            'is_active' => true,
            'note' => $this->faker->text(),
        ];
    }
}