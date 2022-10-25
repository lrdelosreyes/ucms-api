<?php

namespace App\Repositories;

use App\Http\Resources\ContactResource;
use App\Models\Address;
use App\Models\Contact;
use Illuminate\Support\Facades\DB;

class ContactRepository {

    public function create(array $attributes) {
        return DB::transaction(function() use($attributes) {
            $addressIds = [];
            $created = Contact::query()->create([
                'first_name' => data_get($attributes, 'first_name'),
                'last_name' => data_get($attributes, 'last_name'),
                'email' => data_get($attributes, 'email'),
                'mobile' => data_get($attributes, 'mobile'),
                'comments' => data_get($attributes, 'comments'),
            ]);

            if ($attributes['address_physical']) {
                $address = Address::create([
                    'address_type' => 'physical',
                    'address' => data_get($attributes, 'address_physical')
                ]);
                $addressIds[] = $address->id;
            }

            if ($attributes['address_billing']) {
                $address = Address::create([
                    'address_type' => 'billing',
                    'address' => data_get($attributes, 'address_billing')
                ]);
                $addressIds[] = $address->id;
            }

            if (count($addressIds) > 0) {
                $created->addresses()->sync($addressIds);
            }

            return $created;
        });
    }

    public function update(Contact $contact, array $attributes) {
        return DB::transaction(function() use($contact, $attributes) {
            $updated = $contact->update([
                'first_name' => data_get($attributes, 'first_name', $contact->first_name),
                'last_name' => data_get($attributes, 'last_name', $contact->last_name),
                'email' => data_get($attributes, 'email', $contact->email),
                'mobile' => data_get($attributes, 'mobile', $contact->mobile),
                'comments' => data_get($attributes, 'comments', $contact->comments),
            ]);

            if (!$updated) {
                throw new \Exception('Failed to update contact.');
            }

            /*
            if ($addressIds = data_get($attributes, 'address_ids')) {
                $updated->addresses()->sync($addressIds);
            }*/

            return $updated;
        });
    }

    public function forceDelete() {

    }

}
