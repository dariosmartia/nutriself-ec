<?php

namespace App\Models;

use App\Models\Campaign;
use Illuminate\Database\Eloquent\Model;

class Prospect extends Model
{
     protected $fillable = [
        'campaign_id',
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

    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }
}
