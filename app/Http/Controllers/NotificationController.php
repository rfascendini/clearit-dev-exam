<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{

    public function index(Request $request)
    {
        $user = $request->user();

        return view('notifications.index', [
            'notifications' => $user->notifications()
                ->latest()
                ->get(),
        ]);
    }

    public function read(Request $request, string $id)
    {
        $notification = $request->user()
            ->notifications()
            ->where('id', $id)
            ->firstOrFail();

        $notification->markAsRead();

        return redirect()->route('notifications.index');
    }

    public function readAll(Request $request)
    {
        $request->user()->unreadNotifications->markAsRead();

        return redirect()->route('notifications.index');
    }
}
