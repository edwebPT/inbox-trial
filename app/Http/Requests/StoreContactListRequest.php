<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreContactListRequest extends FormRequest
{
    public function authorize() { return true; }
    public function rules()
    {
        return ['name' => 'required|string|max:255'];
    }
    public function messages(): array
    {
        return [
            'name.required' => 'Name is required.'
        ];
    }
}
