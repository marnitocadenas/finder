<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\DashboardStats;
use App\Models\ActivityLog;
use App\Models\Claim;
use App\Models\FoundItem;
use App\Models\LostItem;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $pendingClaims = Claim::where('status', 'pending')->count();
        $openLost = LostItem::where('status', 'lost')->count();
        $unclaimedFound = FoundItem::where('status', 'unclaimed')->count();
        $approvedClaims = Claim::where('status', 'approved')->count();
        $totalClaims = Claim::count();
        $resolutionRate = $totalClaims > 0 ? round(($approvedClaims / $totalClaims) * 100) : 0;

        $overview = [
            [
                'label' => 'Pending claims',
                'value' => $pendingClaims,
                'icon' => 'fa-hourglass-half',
                'tone' => 'warning',
                'route' => route('admin.claims.index', ['status' => 'pending']),
            ],
            [
                'label' => 'Open lost reports',
                'value' => $openLost,
                'icon' => 'fa-location-dot',
                'tone' => 'danger',
                'route' => route('admin.lost-items.index', ['status' => 'lost']),
            ],
            [
                'label' => 'Unclaimed found items',
                'value' => $unclaimedFound,
                'icon' => 'fa-box',
                'tone' => 'success',
                'route' => route('admin.found-items.index', ['status' => 'unclaimed']),
            ],
        ];

        return view('dashboards.admin', [
            'stats' => DashboardStats::admin(),
            'logs' => ActivityLog::with('user')->latest()->take(8)->get(),
            'overview' => $overview,
            'resolutionRate' => $resolutionRate,
            'recentUsers' => User::latest()->take(3)->get(),
        ]);
    }
}
