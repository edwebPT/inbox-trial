<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreContactRequest;
use App\Models\Contact;
use Illuminate\Http\JsonResponse;

class ContactController extends Controller
{
    public function store(StoreContactRequest $request): JsonResponse
    {
        $contact = Contact::create([
            'name' => $request->name,
            'email' => $request->email,
            'status' => $request->status ?? 'active', // default
        ]);

        return response()->json($contact, 201);
    }

    public function index(): JsonResponse
    {
        return response()->json(Contact::all());
    }

    public function unsubscribe($id): JsonResponse
    {
        $contact = Contact::findOrFail($id);
        $contact->update(['status' => 'unsubscribed']);

        return response()->json(['message' => 'Unsubscribed successfully']);
    }

    public function show($id): JsonResponse
    {
        $contact = Contact::findOrFail($id);
        return response()->json($contact);
    }
}
