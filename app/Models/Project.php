<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\ProjectMessage;

class Project extends Model
{
    use HasFactory;

    /**
     * Status disponíveis para um projeto
     */
    public const STATUS_OPEN = 'open';
    public const STATUS_IN_PROGRESS = 'in_progress';
    public const STATUS_COMPLETED = 'completed';
    public const STATUS_CANCELLED = 'cancelled';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'title',
        'description',
        'status',
        'budget',
        'deadline',
        'start_date',
        'end_date',
        'client_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'deadline' => 'datetime',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'budget' => 'decimal:2',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'deadline',
        'start_date',
        'end_date',
        'created_at',
        'updated_at',
    ];

    /**
     * Get the options for the status dropdown.
     *
     * @return array
     */
    public static function getStatusOptions(): array
    {
        return [
            self::STATUS_OPEN => 'Aberto',
            self::STATUS_IN_PROGRESS => 'Em Progresso',
            self::STATUS_COMPLETED => 'Concluído',
            self::STATUS_CANCELLED => 'Cancelado',
        ];
    }

   
    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    
    public function proposals()
    {
        return $this->hasMany(Proposal::class);
    }

    
    public function freelancers(): BelongsToMany
    {
        return $this->belongsToMany(Freelancer::class, 'proposals')
            ->using(Proposal::class)
            ->withPivot(['value', 'deadline', 'description', 'status'])
            ->withTimestamps();
    }

    
    public function scopeOpen($query)
    {
        return $query->where('status', self::STATUS_OPEN);
    }

    
    public function scopeForClient($query, $clientId)
    {
        return $query->where('client_id', $clientId);
    }

    
    public function isOpen(): bool
    {
        return $this->status === self::STATUS_OPEN;
    }

    
    public function getFormattedBudgetAttribute(): string
    {
        return 'R$ ' . number_format($this->budget, 2, ',', '.');
    }

    public function acceptedProposal()
    {
        return $this->hasOne(Proposal::class)->where('status', 'accepted');
    }

    public function messages()
        {
            return $this->hasMany(ProjectMessage::class)->latest();
        }

        public function clientHasRatedFreelancer()
    {
       return $this->ratings()
            ->where('type', 'client_to_freelancer')
            ->where('rater_id', $this->client_id)
            ->exists();
    }

    public function freelancerHasRatedClient()
    {
        return $this->ratings()
            ->where('type', 'freelancer_to_client')
            ->exists();
    }

    public function freelancer()
    {
        return $this->belongsTo(User::class, 'freelancer_id');
    }
}