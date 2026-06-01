<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prospect extends Model
{
     protected $fillable = [
        'name',
        'phone',
        'email',
        'source',
        'main_goal',
        'preferred_modality',
        'interest_level',
        'status',
        'ai_summary',
        'notes',
    ];
}
