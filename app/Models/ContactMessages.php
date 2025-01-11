<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactMessages extends BaseModel
{
    use HasFactory;


    protected $table = 'contact_messages';

    protected $fillable = [
        'full_name',
        'phone_number',
        'email',
        'subject',
        'message',
        'published',
    ];
}
