<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    // Definindo relação de um cliente com muitos projetos
    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    // Se necessário, defina a tabela explicitamente
    protected $table = 'clients';

    // Defina os campos que podem ser preenchidos (mass assignment)
    protected $fillable = ['user_id',
        'name',
        'email',
        'password',
        'company_name',
        'phone',
        // outros campos que você precisar
    ];

    // Se a tabela tiver timestamps
    public $timestamps = false;
}

