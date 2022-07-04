<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

use App\Models\AnnouncementComments;

class AnnouncementCommentController extends Controller
{
    public function getAllComments(Request $request) {

        $comments = Comments::join('users', 'users.user_id', '=', 'announcements.user_id')
                        ->skip(isset($request->items) ? ($request->page - 1) * $request->items : 0)
                        ->take(isset($request->items) ? $request->items : 12)
                        ->get([
                            'announcement_id', 'users.user_id',
                            'comment','announcements_comments.created_at', 
                            'announcements_comments.updated_at',
                        ]);

        return $comments;
        
    }

    public function getCommentCount(Request $request) {
        
        return Comments::get()->count();
    }

}
