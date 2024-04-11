<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $userId = $this->user()->id ?? null;
        return [
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone' => 'required|string|max:255|unique:users,phone,' . $userId,
            'email' => 'required|string|email|max:255|unique:users,email,' . $userId,
            'gender' => 'required',
            'password' => 'sometimes|required|string|min:8',
            'role' => ['sometimes', Rule::in(['Admin', 'Staff', 'User', 'SubAdmin'])],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'first_name.required' => 'The first name is required.',
            'last_name.required' => 'The last name is required.',
            'email.required' => 'The email address is required.',
            'email.email' => 'The email address must be valid.',
            'phone.required' => 'The phone number is required.',
            'phone.unique' => 'The phone number has already been taken.',
            'email.unique' => 'The email address has already been taken.',
            'password.required' => 'A password is required.',
            'password.min' => 'The password must be at least 8 characters.',
            'role.required' => 'The role is required.',
            'role.in' => 'The role must be one of the following types: Admin, Staff, User.',
        ];
    }
}
