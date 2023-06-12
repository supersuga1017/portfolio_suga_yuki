<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gyoumu extends Model
{
    use HasFactory;
    protected $table = 'gyoumu';

    protected $casts = [
        'id' => 'string',
    ];
}
