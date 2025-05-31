<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Freelancer extends Model
{
    use HasFactory;

    // Definindo relação de um freelancer com muitas propostas
    public function proposals()
    {
        return $this->hasMany(Proposal::class);
    }

    public function projects()
    {
        return $this->belongsToMany(Project::class, 'proposals');
    }

    // Se necessário, defina a tabela explicitamente
    protected $table = 'freelancers';

    // Defina os campos que podem ser preenchidos (mass assignment)
    protected $fillable = ['user_id',
        'name', 'email', 'password', 'skills', 'experience', 
        // outros campos que você precisar
    ];

    // Se a tabela tiver timestamps
    public $timestamps = true;
}
