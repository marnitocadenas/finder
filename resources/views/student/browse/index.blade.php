@extends('layouts.app')
@section('title','Browse Found Items')
@section('content')
<div class="browse-module">
    <div class="browse-hero">
        <div>
            <span class="module-eyebrow">Student search</span>
            <h1>Browse Found Items</h1>
            <p>Search verified found items posted by staff and file a claim when you recognize your belongings.</p>
        </div>
        <a href="{{ route('student.claims.index') }}" class="btn btn-light">
            <i class="fa-solid fa-file-signature me-1"></i>My Claims
        </a>
    </div>

    <div class="browse-stat-grid">
        @foreach($browseStats as $stat)
            <div class="browse-stat-card browse-stat-{{ $stat['tone'] }}">
                <span><i class="fa-solid {{ $stat['icon'] }}"></i></span>
                <div>
                    <small>{{ $stat['label'] }}</small>
                    <strong>{{ $stat['value'] }}</strong>
                </div>
            </div>
        @endforeach
    </div>

    <section class="browse-panel">
        <div class="browse-panel-header">
            <div>
                <span class="module-eyebrow">Catalog</span>
                <h2>Found Item Listings</h2>
            </div>
            <span class="browse-result-count">{{ $items->total() }} results</span>
        </div>

        @include('partials.filters', ['statuses' => ['unclaimed', 'claimed', 'turned_over']])

        <div class="browse-grid">
            @forelse($items as $item)
                <article class="browse-card">
                    <div class="browse-card-media">
                        @if($item->image)
                            <img src="{{ asset('storage/'.$item->image) }}" alt="{{ $item->title }}">
                        @else
                            <div>
                                <i class="fa-solid {{ $item->category->icon ?? 'fa-box-open' }}"></i>
                            </div>
                        @endif
                        <x-status :status="$item->status" />
                    </div>
                    <div class="browse-card-body">
                        <div class="browse-card-heading">
                            <span class="browse-category">
                                <i class="fa-solid {{ $item->category->icon ?? 'fa-tag' }}"></i>
                                {{ $item->category->name ?? 'Uncategorized' }}
                            </span>
                            <h3>{{ $item->title }}</h3>
                        </div>
                        <div class="browse-meta">
                            <span><i class="fa-solid fa-calendar-day"></i>{{ optional($item->date_found)->format('M d, Y') ?: 'No date' }}</span>
                            <span><i class="fa-solid fa-location-dot"></i>{{ $item->location_found }}</span>
                        </div>
                        <p>{{ Illuminate\Support\Str::limit($item->description, 135) }}</p>
                    </div>
                    <div class="browse-card-footer">
                        @if($item->status === 'unclaimed')
                            <a href="{{ route('student.claims.create', ['found_item_id' => $item->id]) }}" class="btn btn-primary">
                                <i class="fa-solid fa-file-signature me-1"></i>File Claim
                            </a>
                        @else
                            <span class="browse-unavailable">
                                <i class="fa-solid fa-lock"></i>Claim unavailable
                            </span>
                        @endif
                    </div>
                </article>
            @empty
                <div class="browse-empty">
                    <i class="fa-solid fa-box-open"></i>
                    <p>No found items match your filters.</p>
                </div>
            @endforelse
        </div>

        <div class="browse-pagination">
            {{ $items->links() }}
        </div>
    </section>
</div>
@endsection
