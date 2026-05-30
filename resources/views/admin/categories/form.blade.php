@php($icons = ['fa-laptop','fa-shirt','fa-file-lines','fa-glasses','fa-briefcase','fa-key','fa-box','fa-book','fa-mobile-screen','fa-wallet','fa-headphones','fa-umbrella','fa-calculator','fa-id-card','fa-bottle-water'])
<div class="category-form-module">
    <div class="categories-hero">
        <div>
            <span class="module-eyebrow">Category setup</span>
            <h1>{{ $category->exists ? 'Edit Category' : 'Create Category' }}</h1>
            <p>{{ $category->exists ? 'Update the label and icon used across lost and found records.' : 'Add a new category to make item reporting and matching easier.' }}</p>
        </div>
        <a href="{{ route('admin.categories.index') }}" class="btn btn-light">
            <i class="fa-solid fa-arrow-left me-1"></i>Back to Categories
        </a>
    </div>

    <form method="POST" action="{{ $action }}" class="category-form-card">
        @csrf
        @if($method !== 'POST')
            @method($method)
        @endif

        <div class="category-form-section">
            <div>
                <h2>Category Details</h2>
                <p>Choose a short name and icon that staff and students can recognize quickly.</p>
            </div>
            <div class="row g-3">
                <div class="col-12">
                    <label class="form-label" for="category-name">Name</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fa-solid fa-tag"></i></span>
                        <input id="category-name" class="form-control" name="name" value="{{ old('name', $category->name) }}" placeholder="Category name" required>
                    </div>
                </div>
                <div class="col-12">
                    <label class="form-label">Icon</label>
                    <div class="category-icon-picker">
                        @foreach($icons as $icon)
                            <label>
                                <input type="radio" name="icon" value="{{ $icon }}" @checked(old('icon', $category->icon ?: 'fa-box') === $icon)>
                                <span>
                                    <i class="fa-solid {{ $icon }}"></i>
                                    <small>{{ str_replace('fa-', '', $icon) }}</small>
                                </span>
                            </label>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="category-form-actions">
            <button class="btn btn-primary">
                <i class="fa-solid fa-floppy-disk me-1"></i>Save Category
            </button>
            <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary">Cancel</a>
        </div>
    </form>
</div>
