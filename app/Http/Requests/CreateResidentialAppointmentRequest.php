<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateResidentialAppointmentRequest extends FormRequest
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
            'phone' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',

            'address.street1' => 'required|string|max:255',
            'address.street2' => 'nullable|string|max:255',
            'address.city' => 'required|string|max:255',
            'address.province' => 'required|string|max:255',
            'address.postal_code' => 'required|string|max:10',

            'service_details.home_size' => 'required|string|max:255',
            'service_details.bathrooms' => 'required|string|max:255',

            'availability.primary_date' => 'required|date_format:Y-m-d|after_or_equal:today',
            'availability.secondary_date' => 'nullable|date_format:Y-m-d|after_or_equal:today',
            'availability.time_preferences' => 'required|array',
            'availability.time_preferences.*' => 'in:any_time,morning,afternoon,evening',

            'extras' => 'sometimes|array',
            'extras.*' => 'string|in:fridge,oven,windows,walls,baseboard,doors, door frames & door knobs,fans,moveInOut,deepClean,extremeDeepClean,blinds,heavyDuty,bathroomCabinets,dishes',
            // 'extras.*' => 'string|in:Inside Fridge,Inside Oven,Inside Windows,Walls,Baseboard Cleaning,Doors, door frames & door knobs,Ceiling Fans,Move in/Move Out Cleaning,Deep Cleaning Service,Extreme Deep Clean,Blinds,Heavy-duty Cleaning,Inside Bathroom Cabinets,Dishes',

            'extras_2.entry_method' => 'required|string|max:255',
            'extras_2.home_status' => 'required|string|max:255',
            'extras_2.pets' => 'required|string|max:255',
            'extras_2.basement' => 'required|string|max:255',

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

            'service_details.home_size.required' => 'Please specify the home size.',
            'service_details.home_size.string' => 'Home size must be a string.',
            'service_details.home_size.max' => 'Home size may not be greater than 255 characters.',
            'service_details.bathrooms.required' => 'Please specify the number of bathrooms.',
            'service_details.bathrooms.string' => 'Bathrooms must be a string.',
            'service_details.bathrooms.max' => 'Bathrooms information may not be greater than 255 characters.',

            'availability.primary_date.required' => 'Please select a primary date for availability.',
            'availability.primary_date.date_format' => 'Primary date must be in the format: year-month-day.',
            'availability.secondary_date.date_format' => 'Secondary date must be in the format: year-month-day.',
            'availability.primary_date.after_or_equal' => 'The primary date must be today or a future date.',
            'availability.secondary_date.after_or_equal' => 'The secondary date must be today or a future date.',
            'availability.time_preferences.required' => 'Please select at least one time preference.',
            'availability.time_preferences.array' => 'Time preferences must be an array.',
            'availability.time_preferences.*.in' => 'Selected time preference is invalid.',

            'extras.array' => 'Extras must be an array.',
            'extras.*.string' => 'Each extra must be a string.',
            'extras.*.in' => 'Selected extra is invalid.',

            'extras_2.entry_method.required' => 'Please specify the entry method.',
            'extras_2.home_status.required' => 'Please specify the home status.',
            'extras_2.pets.required' => 'Please specify if there are pets.',
            'extras_2.basement.required' => 'Please specify if there is a basement.',

            'additional_instructions.string' => 'Additional instructions must be a string.',

            'image_paths.array' => 'Images must be uploaded as an array.',
            'image_paths.*.image' => 'Each file must be an image.',
            'image_paths.*.mimes' => 'Each image must be a type of jpg, jpeg, png, gif, svg.',
            'image_paths.*.max' => 'Each image may not be greater than 2048 kilobytes.',
        ];
    }
}
