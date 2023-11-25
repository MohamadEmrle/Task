<?php

namespace App\Http\Requests\Content;

use Illuminate\Foundation\Http\FormRequest;

class storeRequest extends FormRequest
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
            'service_id' => 'required',
            'name'       => 'required',
            'type'       => 'required',
            'phone'      => 'required',
            'email'      => 'required',
            'image'      => 'required',
        ];
    }
}
