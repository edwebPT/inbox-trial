<?php

namespace App\Services;

use App\Models\ContactList;

class ContactListService
{

    public function create(array $data): ContactList
    {
        return ContactList::create($data);
    }

    public function addContact(ContactList $list, int $contactId)
    {
        $list->contacts()->syncWithoutDetaching([$contactId]);
    }

}
