<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePersonnelRequest extends FormRequest
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
            'badge_number' => 'required|string|max:255|unique:personnel,badge_number',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:personnel,email',
            'phone' => 'nullable|string|max:20',
            'rank' => 'required|in:officer,sergeant,lieutenant,captain,major,chief',
            'department' => 'required|string|max:255',
            'status' => 'required|in:active,inactive,suspended,retired',
            'hire_date' => 'required|date',
            'address' => 'nullable|string',
            'birth_date' => 'nullable|date|before:today',
            'gender' => 'nullable|in:male,female,other',
            'emergency_contact_name' => 'nullable|string|max:255',
            'emergency_contact_phone' => 'nullable|string|max:20',
            'documents' => 'nullable|array',
            'documents.*' => 'file|mimes:pdf,doc,docx,jpg,jpeg,png,txt|max:10240',
            'notes' => 'nullable|string',
        ];
    }

    /**
     * Get custom error messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'badge_number.required' => 'Badge number is required.',
            'badge_number.unique' => 'This badge number already exists.',
            'first_name.required' => 'First name is required.',
            'last_name.required' => 'Last name is required.',
            'email.required' => 'Email address is required.',
            'email.email' => 'Please provide a valid email address.',
            'email.unique' => 'This email is already registered.',
            'rank.required' => 'Officer rank is required.',
            'department.required' => 'Department is required.',
            'status.required' => 'Employment status is required.',
            'hire_date.required' => 'Hire date is required.',
            'hire_date.date' => 'Please provide a valid hire date.',
            'birth_date.date' => 'Please provide a valid birth date.',
            'birth_date.before' => 'Birth date must be before today.',
            'documents.*.file' => 'Documents must be valid files.',
            'documents.*.mimes' => 'Documents must be PDF, DOC, DOCX, JPG, JPEG, PNG, or TXT files.',
            'documents.*.max' => 'Documents must not exceed 10MB.',
        ];
    }
}