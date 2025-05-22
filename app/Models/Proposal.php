<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proposal extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'project_id',
        'message',
        'price',
        'deadline',
        'status',
    ];

    // Relação com o projeto (cada proposta pertence a um projeto)
    public function project()
    {
        return $this->belongsTo(\App\Models\Project::class);
    }


    // Relação com o usuário (freelancer que enviou a proposta)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
