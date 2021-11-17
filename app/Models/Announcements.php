<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Announcements extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'memo_id',
        'title',
        'body',
        'comment_no',
        'created_at'
    ];

}
