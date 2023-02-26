<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateHomeRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title' => [
                'required',
                Rule::unique('homes')->ignore($this->home->id),
            ],
            'user_id' => 'nullable|exists:users, id',
            'services' => 'exists:services,id',
            'messages' => 'exists:messages,id',

            'slug' => 'max:255',
            'rooms' => 'required|min:1',
            'beds' => 'required|min:1',
            'bathrooms' => 'required|min:1',
            'square_meters' => 'required|min:1',
            'address' => 'required|min:5|max:255',
            'latitude' => 'nullable|min:1|max:100',
            'longitude' => 'nullable|min:1|max:100',
            'cover_image' => 'image',
            'visible' => 'required'
        ];
    }
}
