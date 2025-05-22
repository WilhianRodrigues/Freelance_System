<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    // Definindo os campos que podem ser preenchidos
    protected $fillable = [
        'title',        // Título do projeto
        'description',  // Descrição do projeto
        'status',       // Status do projeto (aberto, em andamento, etc)
        'start_date',   // Data de início
        'end_date',     // Data de término
        'client_id',    // ID do cliente
    ];

    // Relacionamento com o Cliente
    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id'); // Supondo que tenha a model Client
    }

    // Relacionamento com as Propostas
    public function proposals()
    {
        return $this->hasMany(Proposal::class, 'project_id');
    }

    // Relacionamento com os Freelancers (via Propostas)
    public function freelancers()
    {
        return $this->belongsToMany(Freelancer::class, 'proposals', 'project_id', 'freelancer_id');
    }
}
