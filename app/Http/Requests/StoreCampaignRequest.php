<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCampaignRequest extends FormRequest
{
    public function authorize() { return true; }
    public function rules()
    {
        return [
            'subject' => 'required|string|max:255',
            'body' => 'required|string',
            'contact_list_id' => 'required|exists:contact_lists,id',
            'scheduled_at' => 'nullable|date',
        ];
    }
    public function messages(): array
    {
        return [
            'subject.required' => 'Subject is required.',
            'subject.string' => 'Subject must be a string.',
            'subject.max' => 'Subject may not be greater than 255 characters.',
            'body.required' => 'Body is required.',
            'body.string' => 'Body must be a string.',
            'contact_list_id.required' => 'Contact list is required.',
            'contact_list_id.exists' => 'Selected contact list does not exist.',
            'scheduled_at.date' => 'Scheduled at must be a valid date.',
        ];
    }
}
