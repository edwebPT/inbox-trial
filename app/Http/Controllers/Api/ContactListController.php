<?php

namespace App\Http\Controllers\Api;

use App\Models\ContactList;
use App\Services\ContactListService;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreContactListRequest;
use App\Http\Resources\ContactListResource;
use Illuminate\Http\Request;

class ContactListController extends Controller
{

    public function index()
    {
        return ContactListResource::collection(
            ContactList::withCount('contacts')->get()
        );
    }

    public function store(StoreContactListRequest $request, ContactListService $service)
    {
        $list = $service->create($request->validated());

        return new ContactListResource($list);
    }

    public function addContact($id, Request $request, ContactListService $service)
    {
        $request->validate([
            'contact_id' => 'required|exists:contacts,id'
        ]);

        $list = ContactList::findOrFail($id);

        $service->addContact($list, $request->contact_id);

        return response()->json([
            'message' => 'Contact added to list'
        ]);
    }
}
