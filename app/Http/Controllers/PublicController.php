<?php
namespace App\Http\Controllers;
use App\Models\Category;
use App\Models\FoundItem;
use Illuminate\Http\Request;
use Illuminate\View\View;
class PublicController extends Controller
{ public function index(Request $request): View { return view('public.home',['foundItems'=>FoundItem::with('category')->filtered($request->only('q','category_id'))->latest()->take(8)->get(),'categories'=>Category::orderBy('name')->get()]); } }
