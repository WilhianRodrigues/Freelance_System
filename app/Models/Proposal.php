<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Proposal extends Model
{
    use HasFactory;

    /**
     * @var array
     */
    protected $fillable = [
        'project_id',
        'freelancer_id',
        'message',
        'budget',
        'deadline',
        'status'
    ];

    /**
     * @var array
     */
    protected $casts = [
        'deadline' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

   
    public const STATUS_PENDING = 'pending';
    public const STATUS_ACCEPTED = 'accepted';
    public const STATUS_REJECTED = 'rejected';
    public const STATUS_COMPLETED = 'completed';

    
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    
    public function freelancer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'freelancer_id');
    }

    
    public function scopePending($query)
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    
    public function isPending(): bool
    {
        return $this->status === self::STATUS_PENDING;
    }
}