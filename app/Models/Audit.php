<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Audit extends Model
{
    protected $casts = [
        'old_values' => 'array',
        'new_values' => 'array',
    ];
}
