<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreCareerRequest extends FormRequest
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
            'title' => 'required|string',
            'position_id' => 'required|exists:positions,id',
            'department_id' => 'required|exists:departments,id',
            'location_id' => 'required|exists:locations,id',
            'posts' => 'required|numeric',
            'requirements' => 'required|string',
        ];
    }
}
