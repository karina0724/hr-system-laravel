<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\User;

class RegisterRequest extends FormRequest
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
            'username' => [
                'string',
                'regex:/^[a-zA-Z0-9_ ]+$/',
                'max:50'
            ],
            'password' => [
                'nullable',
                'string',
                'min:6',
                Rule::requiredIf($this->input('auth_type') === 'local') // Password is required only for local auth
            ],
            'email' => [
                'required',
                'string',
                'email',
                'max:100',
            ],
            'role' => 'required|in:recruiter,candidate',
            'auth_type' => 'required|in:local,google',
            'google_id' => 'nullable|string|max:100',
            'profile_picture' => 'nullable|string|max:255',
            'email_verified' => 'boolean',
            'status' => 'in:active,disabled'
        ];
    }

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator($validator)
    {
        // Only run this logic if the auth_type is 'local'
        if ($this->input('auth_type') === 'local') {
            $validator->after(function ($validator) {
                // Check if the email is already registered
                $existingUser = User::where('email', $this->input('email'))->first();

                if ($existingUser) {
                    $validator->errors()->add('email', 'El campo correo electrónico ya ha sido registrado.');
                }
            });
        }
    }
}
