<?php

namespace App\Models;

use App\Enums\TaskPriority;
use App\Enums\TaskStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'name',
        'description',
        'status',
        'priority',
        'due_date',
        'completed_at',
    ];

    protected $casts = [
        'status' => TaskStatus::class,
        'priority' => TaskPriority::class,
        'due_date' => 'date',
        'completed_at' => 'datetime',
    ];

    /**
     * Query Scopes
     */

    public function scopeOfStatus($query, TaskStatus $status)
    {
        return $query->where('status', $status);
    }

    public function scopeOfPriority($query, TaskPriority $priority)
    {
        return $query->where('priority', $priority);
    }

    /**
     * Helper Methods
     */

    public function markAsCompleted(): bool
    {
        return $this->update([
            'status' => TaskStatus::COMPLETED,
            'completed_at' => now(),
        ]);
    }

    public function isCompleted(): bool
    {
        return $this->status === TaskStatus::COMPLETED;
    }

    public function isOverdue(): bool
    {
        return $this->due_date && $this->due_date->isPast() && !$this->isCompleted();
    }

    public function isPending(): bool
    {
        return $this->status === TaskStatus::PENDING;
    }

    public function isHighPriority(): bool
    {
        return $this->priority === TaskPriority::HIGH;
    }
}
