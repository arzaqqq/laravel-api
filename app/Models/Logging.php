<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Logging extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'ip_address',
        'message',
        'action'
    ];
}
