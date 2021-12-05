<?php

namespace App\Http\Controllers;

use App\User;
use App\Http\Controllers\Controller;

class ApplicationController extends Controller
{
    public function index()
    {
        return view('FacultyManagement');
    }

    public function index2()
    {
        return view('StudentManagement');
    }
}
