<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
   protected $fillable = [
    'project_id',
    'rater_id',
    'rated_id', 
    'score',
    'comment',
    'type'
];

public function project()
{
    return $this->belongsTo(Project::class);
}

public function rater()
{
    return $this->belongsTo(User::class, 'rater_id');
}

public function rated()
{
    return $this->belongsTo(User::class, 'rated_id');
}
}
