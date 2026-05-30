<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\FoundItem;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BrowseController extends Controller
{
    public function index(Request $request): View
    {
        $browseStats = [
            ['label' => 'Available', 'value' => FoundItem::where('status', 'unclaimed')->count(), 'icon' => 'fa-box-open', 'tone' => 'success'],
            ['label' => 'Claimed', 'value' => FoundItem::where('status', 'claimed')->count(), 'icon' => 'fa-circle-check', 'tone' => 'primary'],
            ['label' => 'Turned Over', 'value' => FoundItem::where('status', 'turned_over')->count(), 'icon' => 'fa-building-shield', 'tone' => 'warning'],
        ];

        return view('student.browse.index', [
            'items' => FoundItem::with('category')->filtered($request->all())->latest()->paginate(12)->withQueryString(),
            'categories' => Category::orderBy('name')->get(),
            'browseStats' => $browseStats,
        ]);
    }
}
