<div class="module-stats">
    @foreach($stats as $stat)
        <div class="metric-card metric-card-{{ $stat['color'] }}">
            <div>
                <span>{{ $stat['label'] }}</span>
                <strong>{{ $stat['value'] }}</strong>
                @if(! empty($stat['helper']))
                    <small>{{ $stat['helper'] }}</small>
                @endif
            </div>
            <div class="metric-icon text-{{ $stat['color'] }}">
                <i class="fa-solid {{ $stat['icon'] }}"></i>
            </div>
        </div>
    @endforeach
</div>
