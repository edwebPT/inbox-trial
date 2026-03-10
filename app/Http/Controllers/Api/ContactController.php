<?php

namespace App\Http\Controllers\Api;

use App\Models\Contact;
use App\Services\ContactService;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreContactRequest;
use App\Http\Resources\ContactResource;

class ContactController extends Controller
{

    public function index()
    {
        return ContactResource::collection(
            Contact::paginate(15)
        );
    }

    public function store(StoreContactRequest $request, ContactService $service)
    {
        $contact = $service->create($request->validated());

        return new ContactResource($contact);
    }

    public function unsubscribe($id, ContactService $service)
    {
        $contact = Contact::findOrFail($id);

        $service->unsubscribe($contact);

        return new ContactResource($contact);
    }
}
