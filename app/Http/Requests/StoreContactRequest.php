<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreContactRequest extends FormRequest
{
    public function authorize() { return true; }
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:contacts,email',
            'status' => 'required|in:subscribed,unsubscribed',
        ];
    }
    public function messages(): array
    {
        return [
            'name.required' => 'Name is required.',
            'email.required' => 'Email is required.',
            'email.email' => 'Email must be valid.',
            'email.unique' => 'This email is already registered.',
            'status.in' => 'Status must be either active or unsubscribed.',
        ];
    }
}
