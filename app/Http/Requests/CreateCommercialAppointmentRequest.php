<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateCommercialAppointmentRequest extends FormRequest
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
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'company_name' => 'nullable|string|max:255',
            'phone' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',

            'address.street1' => 'required|string|max:255',
            'address.street2' => 'nullable|string|max:255',
            'address.city' => 'required|string|max:255',
            'address.province' => 'required|string|max:255',
            'address.postal_code' => 'required|string|max:10',

            'service_details.information' => 'required|string',

            'availability.primary_date' => 'required|date_format:Y-m-d|after_or_equal:today',
            'availability.secondary_date' => 'nullable|date_format:Y-m-d|after_or_equal:today',
            'availability.time_preferences' => 'required|array',
            'availability.time_preferences.*' => 'in:any_time,morning,afternoon,evening',

            'additional_instructions' => 'nullable|string',

            'image_paths' => 'nullable|array',
            'image_paths.*' => 'image|mimes:jpg,jpeg,png,gif,svg,webp|max:2048',


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
            'first_name.required' => 'Please enter your first name.',
            'first_name.string' => 'First name must be a string.',
            'first_name.max' => 'First name may not be greater than 255 characters.',
            'last_name.required' => 'Please enter your last name.',
            'last_name.string' => 'Last name must be a string.',
            'last_name.max' => 'Last name may not be greater than 255 characters.',
            'phone.required' => 'A phone number is required.',
            'phone.string' => 'Phone number must be a string.',
            'phone.max' => 'Phone number may not be greater than 255 characters.',
            'email.required' => 'An email address is required.',
            'email.string' => 'Email must be a string.',
            'email.email' => 'Please enter a valid email address.',
            'email.max' => 'Email may not be greater than 255 characters.',

            'company_name.string' => 'Company name must be a string.',
            'company_name.max' => 'Company name may not be greater than 255 characters.',

            'address.street1.required' => 'Street 1 is required.',
            'address.street1.string' => 'Street 1 must be a string.',
            'address.street1.max' => 'Street 1 may not be greater than 255 characters.',
            'address.street2.string' => 'Street 2 must be a string.',
            'address.street2.max' => 'Street 2 may not be greater than 255 characters.',
            'address.city.required' => 'City is required.',
            'address.city.string' => 'City must be a string.',
            'address.city.max' => 'City may not be greater than 255 characters.',
            'address.province.required' => 'Province is required.',
            'address.province.string' => 'Province must be a string.',
            'address.province.max' => 'Province may not be greater than 255 characters.',
            'address.postal_code.required' => 'Postal code is required.',
            'address.postal_code.string' => 'Postal code must be a string.',
            'address.postal_code.max' => 'Postal code may not be greater than 10 characters.',

            'service_details.information.required' => 'Please provide service information',
            'service_details.information.string' => 'Service information must be a string.',

            'availability.primary_date.required' => 'Please select a primary date for availability.',
            'availability.primary_date.date_format' => 'Primary date must be in the format: year-month-day.',
            'availability.secondary_date.date_format' => 'Secondary date must be in the format: year-month-day.',
            'availability.primary_date.after_or_equal' => 'The primary date must be today or a future date.',
            'availability.secondary_date.after_or_equal' => 'The secondary date must be today or a future date.',
            'availability.time_preferences.required' => 'Please select at least one time preference.',
            'availability.time_preferences.array' => 'Time preferences must be an array.',
            'availability.time_preferences.*.in' => 'Selected time preference is invalid.',

            'additional_instructions.string' => 'Additional instructions must be a string.',

            'image_paths.array' => 'Images must be uploaded as an array.',
            'image_paths.*.image' => 'Each file must be an image.',
            'image_paths.*.mimes' => 'Each image must be a type of jpg, jpeg, png, gif, svg.',
            'image_paths.*.max' => 'Each image may not be greater than 2048 kilobytes.',
        ];
    }
}
