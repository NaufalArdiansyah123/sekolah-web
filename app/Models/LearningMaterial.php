<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LearningMaterial extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'subject',
        'type',
        'description',
        'file_name',
        'file_path',
        'file_size',
        'original_name',
        'mime_type',
        'downloads',
        'status',
        'teacher_id',
        'class_id',
        'created_by',
        'updated_by'
    ];

    protected $casts = [
        'downloads' => 'integer',
        'file_size' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime'
    ];

    protected $attributes = [
        'downloads' => 0,
        'status' => 'draft'
    ];

    // Relationships
    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function class()
    {
        return $this->belongsTo(Classes::class, 'class_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    // Scopes
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }

    public function scopeBySubject($query, $subject)
    {
        return $query->where('subject', $subject);
    }



    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function scopeByClass($query, $classId)
    {
        return $query->where('class_id', $classId);
    }

    public function scopeForStudent($query, $studentClassId)
    {
        return $query->where(function($q) use ($studentClassId) {
            $q->where('class_id', $studentClassId)
              ->orWhereNull('class_id'); // Include materials without specific class
        });
    }

    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('title', 'like', "%{$search}%")
              ->orWhere('description', 'like', "%{$search}%")
              ->orWhere('subject', 'like', "%{$search}%");
        });
    }

    // Accessors
    public function getFormattedFileSizeAttribute()
    {
        if (!$this->file_size) return '0 B';
        
        $bytes = $this->file_size;
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        
        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }
        
        return round($bytes, 2) . ' ' . $units[$i];
    }

    public function getFileUrlAttribute()
    {
        if (!$this->file_path) return null;
        return asset('storage/' . $this->file_path);
    }

    public function getTypeIconAttribute()
    {
        $icons = [
            'document' => '📄',
            'video' => '🎥',
            'presentation' => '📊',
            'exercise' => '📝',
            'audio' => '🎵'
        ];

        return $icons[$this->type] ?? '📄';
    }

    // Methods
    public function incrementDownloads()
    {
        $this->increment('downloads');
    }

    public function isOwnedBy($userId)
    {
        return $this->teacher_id == $userId || $this->created_by == $userId;
    }

    public function canBeEditedBy($userId)
    {
        return $this->isOwnedBy($userId);
    }

    public function canBeDeletedBy($userId)
    {
        return $this->isOwnedBy($userId);
    }
}