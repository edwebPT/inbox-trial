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
            'body.required' => 'Body is required.',
            'contact_list_id.exists' => 'Contact list must exist.',
            'scheduled_at.date' => 'Scheduled date must be valid.',
        ];
    }
}
