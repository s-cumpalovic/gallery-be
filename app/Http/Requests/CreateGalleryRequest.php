<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateGalleryRequest extends FormRequest
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
            'title' => 'sometimes|required|min:2|max:255',
            'description' => 'sometimes|nullable|max:1000',
            'user_id' => 'sometimes|required',
            'images' => 'sometimes|required',
            'body' => 'sometimes|required|min:1|max:1000',
            'gallery_id' => 'sometimes|required',
        ];
    }
}
