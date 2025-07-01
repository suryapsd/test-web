<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\DatabaseNotification;

class NotificationController extends Controller
{
    public function readAllNotif(Request $request)
    {
        $user = Auth::user();
        $user->unreadNotifications->markAsRead();
        return redirect()->back();
    }

    public function read(Request $request, $id) {
        $notification = DatabaseNotification::find($id);
        $notification->markAsRead();
        return redirect()->back();
    }
}
