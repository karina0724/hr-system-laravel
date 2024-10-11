<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Training extends Model
{
    use HasFactory;

    protected $table = 'training';
    protected $primaryKey = 'training_id';
    protected $fillable = [
        'description',
        'level',
        'date_from',
        'date_to',
        'institution',
        'status',
    ];
}
