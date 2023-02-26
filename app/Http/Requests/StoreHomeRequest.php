<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreHomeRequest extends FormRequest
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
            'title' => 'required|unique:homes,title',
            'user_id' => 'nullable|exists:users, id',
            'slug' => 'max:255',
            'services' => 'exists:services,id',
            'messages' => 'exists:messages,id',
            'rooms' => 'required|min:1|numeric|gt:0',
            'beds' => 'required|min:1|numeric|gt:0',
            'bathrooms' => 'required|min:1|numeric|gt:0',
            'square_meters' => 'required|min:1|numeric|gt:0',
            'address' => 'required|min:5|max:255',
            'latitude' => 'nullable|min:1|max:100',
            'longitude' => 'nullable|min:1|max:100',
            'cover_image' => 'required|image',
            'visible' => 'required'
        ];
    }
}
