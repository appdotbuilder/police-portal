<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCaseRequest extends FormRequest
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
            'case_number' => 'required|string|max:255|unique:cases,case_number',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required|in:open,in_progress,closed,archived',
            'priority' => 'required|in:low,medium,high,critical',
            'category' => 'required|in:theft,assault,fraud,traffic,domestic,drug,cybercrime,other',
            'location' => 'nullable|string|max:255',
            'incident_date' => 'nullable|date',
            'assigned_officer_id' => 'nullable|exists:users,id',
            'evidence_files' => 'nullable|array',
            'evidence_files.*' => 'file|mimes:pdf,doc,docx,jpg,jpeg,png,txt|max:10240',
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
            'case_number.required' => 'Case number is required.',
            'case_number.unique' => 'This case number already exists.',
            'title.required' => 'Case title is required.',
            'description.required' => 'Case description is required.',
            'status.required' => 'Case status is required.',
            'priority.required' => 'Case priority is required.',
            'category.required' => 'Case category is required.',
            'incident_date.date' => 'Please provide a valid incident date.',
            'assigned_officer_id.exists' => 'Selected officer does not exist.',
            'evidence_files.*.file' => 'Evidence files must be valid files.',
            'evidence_files.*.mimes' => 'Evidence files must be PDF, DOC, DOCX, JPG, JPEG, PNG, or TXT files.',
            'evidence_files.*.max' => 'Evidence files must not exceed 10MB.',
        ];
    }
}