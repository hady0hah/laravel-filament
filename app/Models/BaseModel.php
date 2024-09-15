<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    use HasFactory;

    protected $attributes = [
        'published' => true, // Default value for the published field
    ];

    protected $casts = [
        'published' => 'boolean', // Cast the published field to boolean
    ];
}
