<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Contact;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ContactTransaction>
 */
class ContactTransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'contact_id' => Contact::pluck('id')->random(),
            'sales_id' => User::pluck('id')->random(),
            'date_contacted' => fake()->dateTimeThisYear(),
            'description' => fake()->paragraph(),
            'notes' => fake()->paragraph(),
        ];
    }
}
