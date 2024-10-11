<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTrainingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user()->role === 'recruiter';
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'description' => 'required|string|max:255',
            'level' => 'required|in:degree,post-graduate,mastery,doctorate,technical,management',
            'date_from' => 'required|date',
            'date_to' => 'required|date',
            'institution' => 'required|string|max:255',
            'status' => 'in:active,deleted',
        ];
    }
}
