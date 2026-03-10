<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreContactListRequest;
use App\Models\ContactList;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactListController extends Controller
{
    public function index()
    {
        // Return all contact lists as flat array
        return response()->json(ContactList::all());
    }

    public function store(StoreContactListRequest $request)
    {
        $list = ContactList::create($request->validated());
        return response()->json($list, 201);
    }

    public function addContact(Request $request, $id)
    {
        $request->validate(['contact_id' => 'required|exists:contacts,id']);
        $list = ContactList::findOrFail($id);
        $contact = Contact::findOrFail($request->contact_id);

        $list->contacts()->syncWithoutDetaching($contact);

        return response()->json($list->contacts);
    }
}
