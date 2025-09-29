<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class UserNotificationController extends Controller
{
  public function index()
    {
        $notifications = Auth::user()->notifications()->latest()->take(10)->get();
        return view('user-notifications.index', compact('notifications'));
    }

}
