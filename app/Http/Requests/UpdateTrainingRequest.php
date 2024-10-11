<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTrainingRequest extends FormRequest
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
            'description' => 'string|max:255',
            'level' => 'in:degree,post-graduate,mastery,doctorate,technical,management',
            'date_from' => 'date',
            'date_to' => 'date',
            'institution' => 'string|max:255',
            'status' => 'in:active,deleted',
        ];
    }
}
