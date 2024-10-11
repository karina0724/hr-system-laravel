<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Candidates extends Model
{
    use HasFactory;
    protected $primaryKey = 'candidate_id';
    protected $fillable = [
        'desired_position',
        'id_number',
        'id_type',
        'name',
        'department',
        'desired_salary',
        'main_competencies',
        'main_trainings',
        'recommended_by',
        'status',
    ];

    // Relación con Positions
    public function position()
    {
        return $this->belongsTo(Positions::class, 'desired_position');
    }
}
