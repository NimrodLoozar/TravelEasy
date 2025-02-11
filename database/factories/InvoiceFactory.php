<?php
namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Invoice;

// use App\Models\Patient;
// use App\Models\Treatment;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Invoice>
 */
class InvoiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    private static $invoiceNumber = 1;

    public function definition(): array
    {
        return [
            // 'patient_id' => Patient::factory(),
            // 'treatment_id' => $treatment->id,
            // 'number' => self::$invoiceNumber++,
            // 'date' => $this->faker->dateTimeBetween('-1 month', 'now')->format('Y-m-d'),
            // 'amount' => $this->faker->randomFloat(2, $amountRange[0], $amountRange[1]),
            // 'status' => $this->faker->randomElement(['betaald', 'onbetaald', 'in behandeling']),
            'created_at' => now(),
            'updated_at' => now()
        ];
    }
}
