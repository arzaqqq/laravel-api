<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Todolist extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id','title','desc','is_done'
    ];

    public function User ():BelongsTo {
        return $this->belongsTo(User::class, 'user_id');
    }
}
