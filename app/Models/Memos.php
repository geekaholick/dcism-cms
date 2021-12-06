<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Memos extends Model
{
    use HasFactory;

    protected $primaryKey = 'memo_id';
}
