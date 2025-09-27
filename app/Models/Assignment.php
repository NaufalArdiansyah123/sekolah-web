<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Assignment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'subject',
        'class_id',
        'teacher_id',
        'due_date',
        'max_score',
        'status',
        'instructions',
        'attachment_path',
        'attachment_name',
        'created_by',
        'updated_by'
    ];

    protected $casts = [
        'due_date' => 'datetime',
    ];

    /**
     * Get the teacher that owns the assignment
     */
    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    /**
     * Get the class that this assignment belongs to
     */
    public function class()
    {
        return $this->belongsTo(Classes::class, 'class_id');
    }

    /**
     * Get the submissions for the assignment
     */
    public function submissions()
    {
        return $this->hasMany(AssignmentSubmission::class);
    }

    /**
     * Get the grades for the assignment
     */
    public function grades()
    {
        return $this->hasMany(Grade::class);
    }

    /**
     * Check if assignment is overdue
     */
    public function isOverdue()
    {
        return $this->due_date < now();
    }

    /**
     * Get status badge color
     */
    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'draft' => 'gray',
            'published' => 'green',
            'closed' => 'red',
            default => 'gray'
        };
    }

    /**
     * Scope for published assignments
     */
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    /**
     * Scope for assignments by subject
     */
    public function scopeBySubject($query, $subject)
    {
        return $query->where('subject', $subject);
    }

    /**
     * Scope for assignments by class
     */
    public function scopeByClass($query, $classId)
    {
        return $query->where('class_id', $classId);
    }

    /**
     * Scope for assignments visible to student
     */
    public function scopeVisibleToStudent($query, $studentClassId)
    {
        return $query->where('class_id', $studentClassId)->published();
    }
}