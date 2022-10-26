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
use PhpParser\Node\Stmt\TryCatch;

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
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreContactRequest  $request
     * @return ContactResource
     */
    public function store(StoreContactRequest $request, ContactRepository $repository)
    {
        try {
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
        } catch (\Exception $ex) {
            abort(500);
        }
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
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateContactRequest  $request
     * @param  \App\Models\Contact  $contact
     * @return ContactResource | JsonResponse
     */
    public function update(UpdateContactRequest $request, Contact $contact, ContactRepository $repository)
    {
        try {
            $updated = $repository->update($contact, $request->only([
                'first_name',
                'last_name',
                'email',
                'mobile',
                'comments',
                'address_physical_id',
                'address_physical',
                'address_billing_id',
                'address_billing',
            ]));

            return new ContactResource($updated);
        } catch (\Exception $ex) {
            abort(500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Contact  $contact
     * @return Illuminate\Http\JsonResponse
     */
    public function destroy(Contact $contact, ContactRepository $repository)
    {
        $deleted = $repository->forceDelete($contact);

        if ($deleted) {
            return new JsonResponse([
                'data' => 'success'
            ]);
        }
    }
}
