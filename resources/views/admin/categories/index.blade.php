@extends('layouts.app')
@section('title','Categories Management')
@section('content')
<div class="categories-module">
    <div class="categories-hero">
        <div>
            <span class="module-eyebrow">Admin taxonomy</span>
            <h1>Categories</h1>
            <p>Organize lost and found records with clear labels and icons for faster browsing and matching.</p>
        </div>
        <a href="{{ route('admin.categories.create') }}" class="btn btn-warning">
            <i class="fa-solid fa-plus me-1"></i>Create Category
        </a>
    </div>

    <div class="category-stat-grid">
        @foreach($categoryStats as $stat)
            <div class="category-stat-card category-stat-{{ $stat['tone'] }}">
                <span><i class="fa-solid {{ $stat['icon'] }}"></i></span>
                <div>
                    <small>{{ $stat['label'] }}</small>
                    <strong>{{ $stat['value'] }}</strong>
                </div>
            </div>
        @endforeach
    </div>

    <section class="categories-panel">
        <div class="categories-panel-header">
            <div>
                <span class="module-eyebrow">Directory</span>
                <h2>Category Records</h2>
            </div>
            <form class="category-search">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input class="form-control" name="q" value="{{ request('q') }}" placeholder="Search categories">
            </form>
        </div>

        <div class="category-grid">
            @forelse($categories as $category)
                <article class="category-card">
                    <div class="category-card-icon">
                        <i class="fa-solid {{ $category->icon }}"></i>
                    </div>
                    <div class="category-card-body">
                        <h3>{{ $category->name }}</h3>
                        <div class="category-usage">
                            <span><i class="fa-solid fa-magnifying-glass"></i>{{ $category->lost_items_count }} lost</span>
                            <span><i class="fa-solid fa-box-open"></i>{{ $category->found_items_count }} found</span>
                        </div>
                    </div>
                    <div class="category-card-actions">
                        <a class="btn btn-sm btn-outline-primary" href="{{ route('admin.categories.edit', $category) }}">
                            <i class="fa-solid fa-pen-to-square me-1"></i>Edit
                        </a>
                        <form class="d-inline" method="POST" action="{{ route('admin.categories.destroy', $category) }}">
                            @csrf @method('DELETE')
                            <button type="button" class="btn btn-sm btn-outline-danger" data-confirm-submit data-confirm-title="Delete category" data-confirm-message="Delete this category? This will fail if items are still using it." data-confirm-button="Delete">
                                <i class="fa-solid fa-trash-can me-1"></i>Delete
                            </button>
                        </form>
                    </div>
                </article>
            @empty
                <div class="category-empty">
                    <i class="fa-solid fa-tags"></i>
                    <p>No categories found.</p>
                </div>
            @endforelse
        </div>

        {{ $categories->links() }}
    </section>
</div>
@include('partials.confirm-modal')
@endsection
