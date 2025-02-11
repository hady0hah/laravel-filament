<?php

namespace App\Models;

use App\Models\Scopes\PublishedScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    use HasFactory;

    protected $fillable = [
        'published'
    ];

    protected $attributes = [
        'published' => true, // Default value for the published field
    ];

    protected $casts = [
        'published' => 'boolean', // Cast the published field to boolean
    ];

    protected static function booted()
    {
        static::addGlobalScope(new PublishedScope());
    }
}
