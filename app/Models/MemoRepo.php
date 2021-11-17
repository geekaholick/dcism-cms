<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemoRepo extends Model
{
    use HasFactory;
    protected $fillable = [
        'announcement_id',
        'memo_path',
    ];

}
