<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCandidatesRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Permitimos esta solicitud para los usuarios autorizados (rol recruiter)
        return auth()->user()->role === 'recruiter';
    }

    public function rules(): array
    {
        return [
            'desired_position' => 'required|exists:positions,position_id',
            'id_number' => 'required|string|max:20',
            'id_type' => 'required|in:personal-id,passport',
            'name' => 'required|string|max:255',
            'department' => 'nullable|string|max:100',
            'desired_salary' => 'nullable|numeric|min:0',
            'main_competencies' => 'nullable|string',
            'main_trainings' => 'nullable|string',
            'recommended_by' => 'nullable|string|max:255',
            'status' => 'in:active,deleted',
        ];
    }
}
