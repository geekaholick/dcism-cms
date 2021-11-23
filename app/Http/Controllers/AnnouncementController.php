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
                        ->where('title', 'like' , "%$request->q%")
                        ->orWhere('body', 'like' , "%$request->q%")
                        ->orWhere('users.first_name', 'like' , "%$request->q%")
                        ->orWhere('users.last_name', 'like' , "%$request->q%")
                        ->skip(($request->page - 1) * $request->items)
                        ->take($request->items)
                        ->orderBy('announcement_id', $request->sort == 'latest' ? 'desc' : 'asc')
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

    public function getAnnouncementCount(Request $request) {
        
        return Announcements::join('users', 'users.user_id', '=', 'announcements.user_id')
        ->where('title', 'like' , "%$request->q%")
        ->orWhere('body', 'like' , "%$request->q%")
        ->orWhere('users.first_name', 'like' , "%$request->q%")
        ->orWhere('users.last_name', 'like' , "%$request->q%")
        ->get([
            'announcement_id', 'users.user_id', 'memo_id', 'title',
            'body', 'comment_no', 'user_email', 'first_name', 'last_name', 
            'user_image', 'announcements.created_at', 'announcements.updated_at',
        ])->count();
    }

    public function getFilteredAnnouncements(Request $request) {

        $announcements = Announcements::join('users', 'users.user_id', '=', 'announcements.user_id')
                        ->where('title', 'like' , "%$request->q%")
                        ->orWhere('body', 'like' , "%$request->q%")
                        ->orWhere('users.first_name', 'like' , "%$request->q%")
                        ->orWhere('users.last_name', 'like' , "%$request->q%")
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

    public function testFunction (Request $request) {

        $announcements = Announcements::join('users', 'users.user_id', '=', 'announcements.user_id')
                        ->where('title', 'like' , "%$request->q%")
                        ->orWhere('body', 'like' , "%$request->q%")
                        ->orWhere('users.first_name', 'like' , "%$request->q%")
                        ->orWhere('users.last_name', 'like' , "%$request->q%")
                        ->skip(($request->page - 1) * $request->items)
                        ->take($request->items)
                        ->get([
                            'announcement_id', 'users.user_id', 'memo_id', 'title',
                            'body', 'comment_no', 'user_email', 'first_name', 'last_name', 
                            'user_image', 'announcements.created_at', 'announcements.updated_at',
                        ]);
        
        return $announcements;

        foreach ($announcements as $announcement) {
            $images = AnnouncementImages::where('announcement_id', '=', $announcement->announcement_id)
                                        ->get(['id', 'announcement_id', 'image_path']);
            $announcement->images = $images;    
        }

        $announcements = $announcements->toArray();

        $paginated_data = array_slice($announcements, ($request->page - 1) * $request->items, $request->items);

        return $paginated_data;



        
        // $announcements = Announcements::join('users', 'users.user_id', '=', 'announcements.user_id')
        //                 ->where('title', 'like' , "%$request->q%")
        //                 ->orWhere('body', 'like' , "%$request->q%")
        //                 ->orWhere('users.first_name', 'like' , "%$request->q%")
        //                 ->orWhere('users.last_name', 'like' , "%$request->q%")
        //                 ->get([
        //                     'announcement_id', 'users.user_id', 'memo_id', 'title',
        //                     'body', 'comment_no', 'user_email', 'first_name', 'last_name', 
        //                     'user_image', 'announcements.created_at', 'announcements.updated_at',
        //                 ]);

        // foreach ($announcements as $announcement) {
        //     $images = AnnouncementImages::where('announcement_id', '=', $announcement->announcement_id)
        //                                 ->get(['id', 'announcement_id', 'image_path']);
        //     $announcement->images = $images;    
        // }

        // $announcements = $announcements->toArray();

        // $paginated_data = array_slice($announcements, ($request->page - 1) * $request->items, $request->items);

        // return $paginated_data;



        // 2073
        // return $announcements->count();
    }

}
