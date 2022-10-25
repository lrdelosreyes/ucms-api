<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreContactRequest;
use App\Http\Requests\UpdateContactRequest;
use App\Http\Resources\ContactResource;
use Illuminate\Http\Request;
use App\Models\Contact;
use App\Repositories\ContactRepository;
use Illuminate\Http\JsonResponse;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return ResourceCollection
     */
    public function index(Request $request)
    {
        $pageSize = $request->page_size ?? 20;
        $contacts = Contact::query()->with('addresses')->paginate($pageSize);

        return ContactResource::collection($contacts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreContactRequest  $request
     * @return ContactResource
     */
    public function store(Request $request, ContactRepository $repository)
    {
        $created = $repository->create($request->only([
            'first_name',
            'last_name',
            'email',
            'mobile',
            'comments',
            'address_physical',
            'address_billing'
        ]));

        return new ContactResource($created);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Contact  $contact
     * @return ContactResource
     */
    public function show(Contact $contact)
    {
        return new ContactResource($contact);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Contact  $contact
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit(Contact $contact)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateContactRequest  $request
     * @param  \App\Models\Contact  $contact
     * @return ContactResource | JsonResponse
     */
    public function update(Request $request, Contact $contact, ContactRepository $repository)
    {
        $updated = $repository->update($contact, $request->only([
            'first_name',
            'last_name',
            'email',
            'mobile',
            'comments',
        ]));

        return new ContactResource($updated);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Contact  $contact
     * @return ContactResource | JsonResponse
     */
    public function destroy(Contact $contact)
    {
        $deleted = $contact->forceDelete();

        if (!$deleted) {
            return new JsonResponse([
                'errors' => [
                    'Could not delete resource.'
                ]
            ], 400);
        }

        return new ContactResource($deleted);
    }
}
