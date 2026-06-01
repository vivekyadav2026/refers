<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Notifications\CustomNotification;

class AdminNotificationController extends Controller
{
    public function create()
    {
        $users = User::orderBy('name')->get();
        return view('admin.notifications.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string|max:1000',
            'target' => 'required|string', // 'all', 'customers', 'partners', or user_id
            'url' => 'nullable|url|max:255',
            'icon' => 'nullable|string|max:50',
            'color' => 'nullable|string|max:50',
        ]);

        $title = $request->title;
        $message = $request->message;
        $url = $request->url;
        $icon = $request->icon ?: 'bell';
        $color = $request->color ?: 'violet';

        $notification = new CustomNotification($title, $message, $url, $icon, $color);

        if ($request->target === 'all') {
            $users = User::whereIn('role', ['customer', 'partner'])->get();
        } elseif ($request->target === 'customers') {
            $users = User::where('role', 'customer')->get();
        } elseif ($request->target === 'partners') {
            $users = User::where('role', 'partner')->get();
        } else {
            $users = User::where('id', $request->target)->get();
        }

        foreach ($users as $user) {
            $user->notify($notification);
        }

        return redirect()->back()->with('success', 'Notification sent successfully to ' . $users->count() . ' user(s).');
    }
}
