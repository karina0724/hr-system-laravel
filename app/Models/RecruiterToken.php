<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecruiterToken extends Model
{
    use HasFactory;

    protected $table = 'recruiter_tokens'; // Nombre de la tabla
    protected $primaryKey = 'token_id';
    public $timestamps = false;
    protected $fillable = [
        'token',
        'email',
        'is_used',
        'created_at',
        'used_at'
    ];
}
