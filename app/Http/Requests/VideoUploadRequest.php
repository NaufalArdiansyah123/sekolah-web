<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\Video;

class VideoUploadRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $maxFileSize = config('video.max_file_size', 104857600); // 100MB default
        $maxFileSizeKB = $maxFileSize / 1024; // Convert to KB for validation
        
        return [
            'title' => [
                'required',
                'string',
                'max:255',
                'min:3'
            ],
            'description' => [
                'nullable',
                'string',
                'max:5000'
            ],
            'category' => [
                'required',
                Rule::in(array_keys(Video::getCategoryOptions()))
            ],
            'status' => [
                'required',
                Rule::in(array_keys(Video::getStatusOptions()))
            ],
            'is_featured' => [
                'nullable',
                'boolean'
            ],
            'video_file' => [
                'required',
                'file',
                'mimes:' . implode(',', config('video.allowed_mimes', ['mp4', 'avi', 'mov', 'wmv', 'flv', 'webm'])),
                'max:' . $maxFileSizeKB
            ],
            'thumbnail' => [
                'nullable',
                'image',
                'mimes:' . implode(',', config('video.thumbnail_mimes', ['jpeg', 'png', 'jpg', 'gif'])),
                'max:2048' // 2MB for thumbnails
            ]
        ];
    }

    /**
     * Get custom error messages for validator errors.
     */
    public function messages(): array
    {
        $maxFileSize = config('video.max_file_size', 104857600);
        $maxFileSizeMB = round($maxFileSize / 1048576, 1); // Convert to MB
        
        return [
            'title.required' => 'Judul video wajib diisi.',
            'title.min' => 'Judul video minimal 3 karakter.',
            'title.max' => 'Judul video maksimal 255 karakter.',
            
            'description.max' => 'Deskripsi maksimal 5000 karakter.',
            
            'category.required' => 'Kategori video wajib dipilih.',
            'category.in' => 'Kategori yang dipilih tidak valid.',
            
            'status.required' => 'Status video wajib dipilih.',
            'status.in' => 'Status yang dipilih tidak valid.',
            
            'video_file.required' => 'File video wajib diupload.',
            'video_file.file' => 'File yang diupload harus berupa file video.',
            'video_file.mimes' => 'Format video yang diizinkan: ' . implode(', ', config('video.allowed_mimes', ['mp4', 'avi', 'mov', 'wmv', 'flv', 'webm'])),
            'video_file.max' => "Ukuran file video maksimal {$maxFileSizeMB}MB.",
            
            'thumbnail.image' => 'Thumbnail harus berupa gambar.',
            'thumbnail.mimes' => 'Format thumbnail yang diizinkan: ' . implode(', ', config('video.thumbnail_mimes', ['jpeg', 'png', 'jpg', 'gif'])),
            'thumbnail.max' => 'Ukuran thumbnail maksimal 2MB.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'title' => 'judul video',
            'description' => 'deskripsi',
            'category' => 'kategori',
            'status' => 'status',
            'is_featured' => 'video unggulan',
            'video_file' => 'file video',
            'thumbnail' => 'thumbnail',
        ];
    }

    /**
     * Handle a failed validation attempt.
     */
    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        // Add additional context for debugging
        if (request()->hasFile('video_file')) {
            $file = request()->file('video_file');
            logger()->error('Video upload validation failed', [
                'file_size' => $file->getSize(),
                'file_mime' => $file->getMimeType(),
                'file_extension' => $file->getClientOriginalExtension(),
                'max_allowed_size' => config('video.max_file_size'),
                'errors' => $validator->errors()->toArray()
            ]);
        }

        parent::failedValidation($validator);
    }
}