<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Models\ContactTransaction;
use App\Http\Requests\StoreContactTransactionRequest;
use App\Http\Requests\UpdateContactTransactionRequest;
use Illuminate\Http\Request;

class ContactTransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreContactTransactionRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreContactTransactionRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ContactTransaction  $contactTransaction
     * @return \Illuminate\Http\Response
     */
    public function show(ContactTransaction $contactTransaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ContactTransaction  $contactTransaction
     * @return \Illuminate\Http\Response
     */
    public function edit(ContactTransaction $contactTransaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateContactTransactionRequest  $request
     * @param  \App\Models\ContactTransaction  $contactTransaction
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateContactTransactionRequest $request, ContactTransaction $contactTransaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ContactTransaction  $contactTransaction
     * @return \Illuminate\Http\Response
     */
    public function destroy(ContactTransaction $contactTransaction)
    {
        //
    }
}
