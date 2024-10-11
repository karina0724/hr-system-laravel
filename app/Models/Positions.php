<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Positions extends Model
{
    use HasFactory;

    protected $primaryKey = 'position_id';
    protected $fillable = [
        'name',
        'risk_level',
        'min_salary',
        'max_salary',
        'status',
    ];
    public $timestamps = true;

    // Relación con Candidates
    public function candidates()
    {
        return $this->hasMany(Candidates::class, 'desired_position');
    }
}
