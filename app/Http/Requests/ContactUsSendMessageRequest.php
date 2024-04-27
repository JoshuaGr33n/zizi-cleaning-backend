<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactUsSendMessageRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // Replace with your authorization logic
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:255',
            'email' => 'required|string|email|max:255',
            'message' => 'required|string|max:5000',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => 'Please enter your name.',
            'name.string' => 'Name must be a string.',
            'name.max' => 'Name may not be greater than 255 characters.',
            'phone.string' => 'Phone number must be a string.',
            'phone.max' => 'Phone number may not be greater than 255 characters.',
            'email.required' => 'An email address is required.',
            'email.string' => 'Email must be a string.',
            'email.email' => 'Please enter a valid email address.',
            'email.max' => 'Email may not be greater than 255 characters.',
            'message.required' => 'Please enter a message.',
            'message.string' => 'Message must be a string.',
            'message.max' => 'Message may not be greater than 5000 characters.',
        ];
    }
}
