<?php

namespace Database\Seeders;

use App\Models\Address;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Contact;

class ContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Contact::factory(100)->create()->each(function($contact) {
            $contactId = $contact->id;

            $addressPhysical = Address::create([
                'address_type' => 'physical',
                'address' => fake()->address()
            ]);
            $addressBilling = Address::create([
                'address_type' => 'billing',
                'address' => fake()->address()
            ]);

            $contact->addresses()->attach($addressPhysical->id);
            $contact->addresses()->attach($addressBilling->id);
        });
    }
}
