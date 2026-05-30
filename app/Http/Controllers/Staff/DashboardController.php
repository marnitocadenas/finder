<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Claim;
use App\Models\FoundItem;
use App\Models\LostItem;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $ids = FoundItem::where('staff_id', $request->user()->id)->pluck('id');
        $itemsPosted = $ids->count();
        $pendingClaims = Claim::whereIn('found_item_id', $ids)->where('status', 'pending')->count();
        $approvedClaims = Claim::whereIn('found_item_id', $ids)->where('status', 'approved')->count();
        $unclaimedItems = FoundItem::where('staff_id', $request->user()->id)->where('status', 'unclaimed')->count();

        $stats = [
            ['label' => 'Items Posted', 'value' => $itemsPosted, 'icon' => 'fa-box-open', 'color' => 'primary'],
            ['label' => 'Pending Claims', 'value' => $pendingClaims, 'icon' => 'fa-clock', 'color' => 'warning'],
            ['label' => 'Approved Claims', 'value' => $approvedClaims, 'icon' => 'fa-circle-check', 'color' => 'success'],
            ['label' => 'Unclaimed Items', 'value' => $unclaimedItems, 'icon' => 'fa-inbox', 'color' => 'danger'],
        ];

        $workQueue = [
            [
                'label' => 'Pending claim reviews',
                'value' => $pendingClaims,
                'icon' => 'fa-hourglass-half',
                'tone' => 'warning',
                'route' => route('staff.claims.index', ['status' => 'pending']),
            ],
            [
                'label' => 'Unclaimed found items',
                'value' => $unclaimedItems,
                'icon' => 'fa-box-open',
                'tone' => 'danger',
                'route' => route('staff.found-items.index', ['status' => 'unclaimed']),
            ],
            [
                'label' => 'Open lost reports',
                'value' => LostItem::where('status', 'lost')->count(),
                'icon' => 'fa-magnifying-glass',
                'tone' => 'primary',
                'route' => route('staff.lost-reports.index', ['status' => 'lost']),
            ],
        ];

        $recentFoundItems = FoundItem::with('category')
            ->where('staff_id', $request->user()->id)
            ->latest()
            ->take(5)
            ->get();

        $recentClaims = Claim::with(['student', 'foundItem.category'])
            ->whereIn('found_item_id', $ids)
            ->latest()
            ->take(5)
            ->get();

        return view('dashboards.staff', compact('stats', 'workQueue', 'recentFoundItems', 'recentClaims'));
    }
}
