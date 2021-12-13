<?php

namespace App\Http\Controllers;

use App\User;
use App\Http\Controllers\Controller;

class ApplicationController extends Controller
{
    public function index()
    {
        return view('application');
    }

    public function sendNotification()
    {
        $user = User::first();
  
        $details = [
            'body' => $this->data,
            'actionText' => 'View My Announcements',
            'actionURL' => url('/'),
        ];
  
        Notification::send($user, new SendNotification($details));
   
        dd('done');
    }
}
