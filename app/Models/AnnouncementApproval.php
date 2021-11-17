<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnnouncementApproval extends Model
{
    use HasFactory;
    protected $fillable = [
        'announcement_id',
        'is_approved'
    ];

}
