<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateSettingRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'url' => 'nullable|url|max:2048',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'tag' => 'required|string|max:255|unique:settings,tag',
            'desc' => 'nullable|string',
            'value' => 'nullable|string|max:255',
            'category' => 'required|string',
        ];
    }

     /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */

    public function messages()
    {
        return [
            'name.required' => 'The name of the setting is required.',
            'name.string' => 'The name must be a valid string.',
            'name.max' => 'The name may not be greater than 255 characters.',
            'url.url' => 'The URL must be a valid URL.',
            'url.max' => 'The URL may not be greater than 2048 characters.',
            // 'image.required' => 'An image file is required.',
            'image.image' => 'The file must be an image.',
            'image.mimes' => 'The image must be a file of type: jpeg, png, jpg, gif, svg.',
            'image.max' => 'The image may not be greater than 2048 kilobytes.',
            'tag.required' => 'The tag is required and helps in identifying the setting uniquely.',
            'tag.string' => 'The tag must be a valid string.',
            'tag.max' => 'The tag may not be greater than 255 characters.',
            'tag.unique' => 'The tag has already been assigned. Please choose a different one.',
            'desc.string' => 'The description must be a valid string.',
            'value.string' => 'The value must be a valid string.',
            'value.max' => 'The value may not be greater than 255 characters.',
            'category.required' => 'Category is required.',
        ];
    }
}
