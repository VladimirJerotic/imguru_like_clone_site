<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notification;

class NotificationController extends Controller
{
    public function get()
    {
    	$notification = auth()->user()->unreadNotifications;
    	return $notification;
    }

    public function read(Request $request)
    {
    	$notif =  Notification::findOrFail($request->id);
    	$notif->delete();
    }
}
