<?php

namespace App\Http\Requests\Site;

use Illuminate\Foundation\Http\FormRequest;

class storeContenteRequest extends FormRequest
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
            'phone'      => 'required|numeric',
            'email'      => 'required|unique:contents,email',
            'image'      => 'required',
        ];
    }
}
