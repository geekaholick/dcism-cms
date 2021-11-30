<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Validation\ValidationException;

use App\Models\Announcements;
use App\Models\AnnouncementImages;
use App\Models\Bookmarks;

class AnnouncementController extends Controller
{
    public function getAllAnnouncements(Request $request) {

        $months = [
            'January' => 1,
            'February' => 2,
            'March' => 3,
            'April' => 4,
            'May' => 5,
            'June' => 6,
            'July' => 7,
            'August' => 8,
            'September' => 9,
            'October' => 10,
            'November' => 11,
            'December' => 12,
        ];
        
        $announcements = Announcements::join('users', 'users.user_id', '=', 'announcements.user_id')
                        ->when(isset($request->month), function ($q) use ($request, $months) {
                            $q->whereMonth('announcements.created_at', $months[$request->month]);
                        })
                        ->when(isset($request->year), function ($q) use ($request) {
                            $q->whereYear('announcements.created_at', $request->year);
                        })
                        ->where(function ($query) use ($request) {
                            $query->where('title', 'like' , "%$request->q%")
                            ->orWhere('body', 'like' , "%$request->q%")
                            ->orWhere('users.first_name', 'like' , "%$request->q%")
                            ->orWhere('users.last_name', 'like' , "%$request->q%");
                        })
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

            // use to check if announcement is bookmarked by the current user
            if (isset($request->user_id)) {
                $bookmarked_result = Bookmarks::where([
                    ['announcement_id', $announcement->announcement_id],
                    ['user_id', $request->user_id]    
                ])->first();

                $announcement->is_bookmarked = $bookmarked_result ? 1 : 0;
            }
        }

        return $announcements;
        
    }

    public function getAnnouncementCount(Request $request) {

        $months = [
            'January' => 1,
            'February' => 2,
            'March' => 3,
            'April' => 4,
            'May' => 5,
            'June' => 6,
            'July' => 7,
            'August' => 8,
            'September' => 9,
            'October' => 10,
            'November' => 11,
            'December' => 12,
        ];
        
        return Announcements::join('users', 'users.user_id', '=', 'announcements.user_id')
        ->when(isset($request->month), function ($q) use ($request, $months) {
            $q->whereMonth('announcements.created_at', $months[$request->month]);
        })
        ->when(isset($request->year), function ($q) use ($request) {
            $q->whereYear('announcements.created_at', $request->year);
        })
        ->where(function ($query) use ($request) {
            $query->where('title', 'like' , "%$request->q%")
            ->orWhere('body', 'like' , "%$request->q%")
            ->orWhere('users.first_name', 'like' , "%$request->q%")
            ->orWhere('users.last_name', 'like' , "%$request->q%");
        })
        ->get([
            'announcement_id', 'users.user_id', 'memo_id', 'title',
            'body', 'comment_no', 'user_email', 'first_name', 'last_name', 
            'user_image', 'announcements.created_at', 'announcements.updated_at',
        ])->count();
    }

    public function bookmarkAnnouncement(Request $request) {
               
        $bookmarked_result = Bookmarks::where([
                                ['announcement_id', $request->announcement_id],
                                ['user_id', $request->user_id]    
                            ])->first();

        if ($bookmarked_result) {
            throw ValidationException::withMessages([
                'error' => ['This announcement is already in your bookmarks.']
            ]);
        }

        $bookmark = new Bookmarks([
            'user_id' => $request->user_id,
            'announcement_id' => $request->announcement_id
        ]);
        $bookmark->save();

        return $bookmark;
    }

    public function unbookmarkAnnouncement(Request $request) {
               
        $bookmarked_result = Bookmarks::where([
                ['announcement_id', $request->announcement_id],
                ['user_id', $request->user_id]    
        ])->first();

        if (!$bookmarked_result) {
            throw ValidationException::withMessages([
                'error' => ['This announcement is not in your bookmark list.']
            ]);
        }
        
        return Bookmarks::where([
                    ['announcement_id', $request->announcement_id],
                    ['user_id', $request->user_id]    
                ])->delete();

    }
}
