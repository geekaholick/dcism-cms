<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

use App\Models\Announcements;
use App\Models\AnnouncementImages;

class AnnouncementController extends Controller
{
    public function getAllAnnouncements(Request $request) {

        $announcements = Announcements::join('users', 'users.user_id', '=', 'announcements.user_id')
                        ->get([
                            'announcement_id', 'users.user_id', 'memo_id', 'title',
                            'body', 'comment_no', 'user_email', 'first_name', 'last_name', 
                            'user_image', 'announcements.created_at', 'announcements.updated_at',
                        ]);

        foreach ($announcements as $announcement) {
            $images = AnnouncementImages::where('announcement_id', '=', $announcement->announcement_id)
                                        ->get(['id', 'announcement_id', 'image_path']);
            $announcement->images = $images;
        }

        return $announcements;
        
    }

}
