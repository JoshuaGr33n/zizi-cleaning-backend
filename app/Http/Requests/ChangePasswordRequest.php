<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // Assuming any authenticated user can change their password
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
            'oldPassword' => 'required',
            'newPassword' => 'required|min:8|confirmed',
        ];
    }

    /**
     * Get custom messages for validation errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'oldPassword.required' => 'The old password field is required.',
            'newPassword.required' => 'The new password field is required.',
            'newPassword.min' => 'The new password must be at least 8 characters.',
            'newPassword.confirmed' => 'The new password confirmation does not match.',
        ];
    }
}
