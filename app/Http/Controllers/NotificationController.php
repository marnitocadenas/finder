<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NotificationController extends Controller
{
    public function index(Request $request): View
    {
        $query = $request->user()->notifications();
        $notificationStats = [
            ['label' => 'All Alerts', 'value' => (clone $query)->count(), 'icon' => 'fa-bell', 'tone' => 'primary'],
            ['label' => 'Unread', 'value' => (clone $query)->where('is_read', false)->count(), 'icon' => 'fa-envelope', 'tone' => 'warning'],
            ['label' => 'Read', 'value' => (clone $query)->where('is_read', true)->count(), 'icon' => 'fa-envelope-open', 'tone' => 'success'],
        ];

        return view('notifications.index', [
            'notifications' => $request->user()->notifications()->latest()->paginate(15),
            'notificationStats' => $notificationStats,
        ]);
    }

    public function markAllRead(Request $request): RedirectResponse
    {
        $request->user()->notifications()->update(['is_read' => true]);

        return back()->with('success', 'Notifications marked as read.');
    }

    public function count(Request $request): JsonResponse
    {
        return response()->json(['count' => $request->user()->notifications()->where('is_read', false)->count()]);
    }
}
