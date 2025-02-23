<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $casts = [
        'completed_at' => 'datetime',
    ];
}
