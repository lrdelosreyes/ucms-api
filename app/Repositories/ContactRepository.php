<?php

namespace App\Repositories;

use App\Events\ContactCreated;
use App\Exceptions\GeneralJsonException;
use App\Models\Address;
use App\Models\Contact;
use Illuminate\Support\Facades\DB;

class ContactRepository extends BaseRepository {

    public function create(array $attributes) {
        return DB::transaction(function() use($attributes) {
            $addressIds = [];
            $addressPhysical = data_get($attributes, 'address_physical', null);
            $addressBilling = data_get($attributes, 'address_billing', null);

            $created = Contact::query()->create([
                'first_name' => data_get($attributes, 'first_name'),
                'last_name' => data_get($attributes, 'last_name'),
                'email' => data_get($attributes, 'email'),
                'mobile' => data_get($attributes, 'mobile'),
                'comments' => data_get($attributes, 'comments'),
            ]);

            if (!$created) {
                throw new GeneralJsonException('Failed to create contact.');
            }

            if ($addressPhysical) {
                $addressIds[] = $this->storeAddress('physical', $addressPhysical);
            }

            if ($addressBilling) {
                $addressIds[] = $this->storeAddress('billing', $addressBilling);
            }

            if (count($addressIds) > 0) {
                $created->addresses()->sync($addressIds);
            }

            event(new ContactCreated($created));

            return $created;
        });
    }

    public function update($contact, array $attributes) {
        return DB::transaction(function() use($contact, $attributes) {
            $addressIds = [];

            $addressPhysicalId = data_get($attributes, 'address_physical_id', null);
            $addressPhysical = data_get($attributes, 'address_physical', null);

            $addressBillingId = data_get($attributes, 'address_billing_id', null);
            $addressBilling = data_get($attributes, 'address_billing', null);

            $updated = $contact->update([
                'first_name' => data_get($attributes, 'first_name', $contact->first_name),
                'last_name' => data_get($attributes, 'last_name', $contact->last_name),
                'email' => data_get($attributes, 'email', $contact->email),
                'mobile' => data_get($attributes, 'mobile', $contact->mobile),
                'comments' => data_get($attributes, 'comments', $contact->comments),
            ]);

            if (!$updated) {
                throw new GeneralJsonException('Failed to update contact.');
            }

            if (!$addressPhysicalId && $addressPhysical) {
                $addressIds[] = $this->storeAddress('physical', $addressPhysical);
            } else if ($addressPhysicalId && $addressPhysical) {
                $addressId = $this->updateAddress(
                    Address::query()->find($addressPhysicalId),
                    'physical',
                    $addressPhysical
                );

                if ($addressId):
                $addressIds[] = $addressId;
                endif;
            }

            if (!$addressBillingId && $addressBilling) {
                $addressIds[] = $this->storeAddress('billing', $addressBilling);
            } else if ($addressBillingId && $addressBilling) {
                $addressId = $this->updateAddress(
                    Address::query()->find($addressBillingId),
                    'billing',
                    $addressBilling
                );

                if ($addressId):
                $addressIds[] = $addressId;
                endif;
            }

            if (count($addressIds) > 0) {
                $contact->addresses()->sync($addressIds);
            }

            return $contact;
        });
    }

    public function forceDelete($contact) {
        return DB::transaction(function() use($contact) {
            $deleted = $contact->forceDelete();

            if (!$deleted) {
                throw new GeneralJsonException('Cannot delete contact.');
            }

            return $deleted;
        });
    }

    private function storeAddress($type, $address) {
        $created = Address::create([
            'address_type' => $type,
            'address' => $address
        ]);

        return $created->id;
    }

    private function updateAddress($model, $type, $address) {
        if (!$model) {
            return null;
        }

        $model->update([
            'address_type' => $type,
            'address' => $address
        ]);

        return $model->id;
    }

}
