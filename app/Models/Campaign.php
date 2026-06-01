<?php

namespace App\Models;

use App\Models\Prospect;
use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    protected $fillable = [
        'name',
        'type',
        'description',
        'start_date',
        'end_date',
        'status',
        'main_message',
        'objective',
    ];

    public function prospects()
    {
        return $this->hasMany(Prospect::class);
    }
}
