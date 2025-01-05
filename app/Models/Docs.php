<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Docs extends BaseModel
{
    use HasFactory;

    protected $table = 'docs';

    protected $fillable = [
        'name',
        'file_path',
        'image_preview',
        'published',
    ];

}
