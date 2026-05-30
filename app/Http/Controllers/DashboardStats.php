<?php

namespace App\Http\Controllers;

use App\Models\Claim;
use App\Models\FoundItem;
use App\Models\LostItem;
use App\Models\User;

class DashboardStats
{
    public static function admin(): array
    {
        return [
            [
                'label' => 'Total Users',
                'value' => User::count(),
                'helper' => 'Registered accounts',
                'icon' => 'fa-users',
                'color' => 'primary',
            ],
            [
                'label' => 'Lost Reports',
                'value' => LostItem::count(),
                'helper' => LostItem::where('status', 'lost')->count().' still open',
                'icon' => 'fa-magnifying-glass',
                'color' => 'danger',
            ],
            [
                'label' => 'Found Items',
                'value' => FoundItem::count(),
                'helper' => FoundItem::where('status', 'unclaimed')->count().' waiting to claim',
                'icon' => 'fa-box-open',
                'color' => 'success',
            ],
            [
                'label' => 'Pending Claims',
                'value' => Claim::where('status', 'pending')->count(),
                'helper' => 'Need review',
                'icon' => 'fa-clipboard-list',
                'color' => 'warning',
            ],
        ];
    }
}
