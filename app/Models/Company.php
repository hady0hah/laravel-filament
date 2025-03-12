<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends BaseModel
{
    use HasFactory;

    protected $table = 'companies';

    protected $fillable = [
        'name',
        'image_path',
        'published',
        'link',
    ];
}
