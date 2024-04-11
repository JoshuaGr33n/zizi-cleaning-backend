<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class NewStaffRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone' => 'required|string|max:255|unique:users,phone|confirmed', 
            'email' => 'required|string|email|max:255|unique:users,email|confirmed',
            'gender' => 'required',
            'role' => ['required', Rule::in(['Admin', 'Staff', 'User', 'SubAdmin'])],
        ];
    }

    public function messages()
    {
        return [
            'email.unique' => 'The email address is already in use.',
            'email.confirmed' => 'Email confirmation does not match.',
            'phone.confirmed' => 'Phone confirmation does not match.',
        ];
    }
}
