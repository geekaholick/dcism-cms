<?php

namespace App\Http\Controllers;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Notification;
use App\Notifications\NewNotification;

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
            'body' => $this->text,
            'actionURL' => url('/'),
        ];
  
        Notification::send($user, new NewNotification($details));
   
        dd('done');
    }
}
