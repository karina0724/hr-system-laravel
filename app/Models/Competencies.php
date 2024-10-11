<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Competencies extends Model
{
    use HasFactory;

    protected $primaryKey = 'competence_id';
    protected $fillable = [
        'description',
        'type',
        'status',
    ];
}
