<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ActivityLogController extends Controller
{
    public function index(Request $request): View
    {
        $logStats = [
            ['label' => 'Total Events', 'value' => ActivityLog::count(), 'icon' => 'fa-clock-rotate-left', 'tone' => 'primary'],
            ['label' => 'Today', 'value' => ActivityLog::whereDate('created_at', today())->count(), 'icon' => 'fa-calendar-day', 'tone' => 'success'],
            ['label' => 'User Actions', 'value' => ActivityLog::whereNotNull('user_id')->count(), 'icon' => 'fa-user-check', 'tone' => 'warning'],
            ['label' => 'System Events', 'value' => ActivityLog::whereNull('user_id')->count(), 'icon' => 'fa-server', 'tone' => 'danger'],
        ];

        return view('admin.logs.index', [
            'logs' => ActivityLog::with('user')->filtered($request->all())->latest()->paginate(15)->withQueryString(),
            'logStats' => $logStats,
        ]);
    }
}
