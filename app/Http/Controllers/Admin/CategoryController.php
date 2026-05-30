<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Concerns\LogsActivity;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class CategoryController extends Controller
{
    use LogsActivity;

    public function index(Request $request): View
    {
        $categories = Category::withCount(['lostItems', 'foundItems'])
            ->when($request->q, fn($q, $t) => $q->where('name', 'like', "%$t%"))
            ->orderBy('name')
            ->paginate(15)
            ->withQueryString();

        $categoryStats = [
            ['label' => 'Categories', 'value' => Category::count(), 'icon' => 'fa-tags', 'tone' => 'primary'],
            ['label' => 'Used by Lost', 'value' => Category::has('lostItems')->count(), 'icon' => 'fa-magnifying-glass', 'tone' => 'danger'],
            ['label' => 'Used by Found', 'value' => Category::has('foundItems')->count(), 'icon' => 'fa-box-open', 'tone' => 'success'],
            ['label' => 'Unused', 'value' => Category::doesntHave('lostItems')->doesntHave('foundItems')->count(), 'icon' => 'fa-layer-group', 'tone' => 'warning'],
        ];

        return view('admin.categories.index', compact('categories', 'categoryStats'));
    }

    public function create(): View
    {
        return view('admin.categories.create', ['category' => new Category()]);
    }

    public function store(Request $request): RedirectResponse
    {
        $category = Category::create($request->validate([
            'name' => 'required|string|max:100|unique:categories,name',
            'icon' => 'required|string|max:80',
        ]));

        $this->logAction($request, 'Created category '.$category->name, $category);

        return redirect()->route('admin.categories.index')->with('success', 'Category created.');
    }

    public function edit(Category $category): View
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category): RedirectResponse
    {
        $category->update($request->validate([
            'name' => ['required', 'string', 'max:100', Rule::unique('categories')->ignore($category)],
            'icon' => 'required|string|max:80',
        ]));

        $this->logAction($request, 'Updated category '.$category->name, $category);

        return redirect()->route('admin.categories.index')->with('success', 'Category updated.');
    }

    public function destroy(Request $request, Category $category): RedirectResponse
    {
        $this->logAction($request, 'Deleted category '.$category->name, $category);
        $category->delete();

        return back()->with('success', 'Category deleted.');
    }
}
