<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StudyProgramRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Adjust based on your authorization logic
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $rules = [
            // Basic Information
            'program_name' => ['required', 'string', 'max:255'],
            'program_code' => ['nullable', 'string', 'max:20'],
            'description' => ['nullable', 'string'],
            'degree_level' => ['required', Rule::in(['D3', 'S1', 'S2', 'S3'])],
            'faculty' => ['nullable', 'string', 'max:255'],
            
            // Vision & Mission
            'vision' => ['nullable', 'string'],
            'mission' => ['nullable', 'string'],
            
            // Career & Admission
            'career_prospects' => ['nullable', 'string'],
            'admission_requirements' => ['nullable', 'string'],
            
            // Academic Details
            'duration_years' => ['nullable', 'integer', 'min:1', 'max:10'],
            'total_credits' => ['nullable', 'integer', 'min:1'],
            'degree_title' => ['nullable', 'string', 'max:100'],
            'accreditation' => ['nullable', Rule::in(['A', 'B', 'C'])],
            
            // Admission & Costs
            'capacity' => ['nullable', 'integer', 'min:1'],
            'tuition_fee' => ['nullable', 'numeric', 'min:0'],
            
            // JSON Data
            'core_subjects_json' => ['nullable', 'json'],
            'specializations_json' => ['nullable', 'json'],
            'facilities_json' => ['nullable', 'json'],
            
            // Media Files
            'program_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:5120'], // 5MB
            'brochure_file' => ['nullable', 'file', 'mimes:pdf,doc,docx', 'max:10240'], // 10MB
            
            // Settings
            'is_active' => ['nullable', 'boolean'],
            'is_featured' => ['nullable', 'boolean'],
        ];

        // Add unique validation for program_code if provided
        if ($this->filled('program_code')) {
            $programId = $this->route('study_program') ? $this->route('study_program')->id : null;
            $rules['program_code'][] = Rule::unique('study_programs', 'program_code')->ignore($programId);
        }

        return $rules;
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'program_name.required' => 'Program name is required.',
            'program_name.max' => 'Program name cannot exceed 255 characters.',
            'degree_level.required' => 'Degree level is required.',
            'degree_level.in' => 'Degree level must be one of: D3, S1, S2, S3.',
            'program_code.unique' => 'This program code is already taken.',
            'duration_years.min' => 'Duration must be at least 1 year.',
            'duration_years.max' => 'Duration cannot exceed 10 years.',
            'capacity.min' => 'Capacity must be at least 1 student.',
            'tuition_fee.min' => 'Tuition fee cannot be negative.',
            'program_image.image' => 'Program image must be an image file.',
            'program_image.mimes' => 'Program image must be a JPEG, PNG, JPG, or GIF file.',
            'program_image.max' => 'Program image cannot exceed 5MB.',
            'brochure_file.mimes' => 'Brochure must be a PDF, DOC, or DOCX file.',
            'brochure_file.max' => 'Brochure file cannot exceed 10MB.',
            'core_subjects_json.json' => 'Core subjects data must be valid JSON.',
            'specializations_json.json' => 'Specializations data must be valid JSON.',
            'facilities_json.json' => 'Facilities data must be valid JSON.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'program_name' => 'program name',
            'program_code' => 'program code',
            'degree_level' => 'degree level',
            'duration_years' => 'duration',
            'total_credits' => 'total credits',
            'degree_title' => 'degree title',
            'tuition_fee' => 'tuition fee',
            'program_image' => 'program image',
            'brochure_file' => 'brochure file',
            'is_active' => 'active status',
            'is_featured' => 'featured status',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // Convert checkbox values to boolean
        $this->merge([
            'is_active' => $this->boolean('is_active'),
            'is_featured' => $this->boolean('is_featured'),
        ]);

        // Clean up numeric fields
        if ($this->filled('tuition_fee')) {
            $this->merge([
                'tuition_fee' => (float) str_replace(',', '', $this->tuition_fee),
            ]);
        }
    }

    /**
     * Get the validated data with processed JSON fields.
     */
    public function getProcessedData(): array
    {
        $data = $this->validated();

        // Process JSON fields
        if (isset($data['core_subjects_json'])) {
            $data['core_subjects'] = json_decode($data['core_subjects_json'], true) ?: [];
            unset($data['core_subjects_json']);
        }

        if (isset($data['specializations_json'])) {
            $data['specializations'] = json_decode($data['specializations_json'], true) ?: [];
            unset($data['specializations_json']);
        }

        if (isset($data['facilities_json'])) {
            $data['facilities'] = json_decode($data['facilities_json'], true) ?: [];
            unset($data['facilities_json']);
        }

        return $data;
    }
}