@if ($tickers->isNotEmpty())
    <div class="announcement-ticker">
        <div class="announcement-ticker-track">
            @foreach ($tickers as $ticker)
                @if ($ticker->url)
                    <a href="{{ $ticker->url }}" class="announcement-item">{{ $ticker->text }}</a>
                @else
                    <span class="announcement-item">{{ $ticker->text }}</span>
                @endif
            @endforeach
            {{-- Repeat once so the scroll loop looks seamless --}}
            @foreach ($tickers as $ticker)
                @if ($ticker->url)
                    <a href="{{ $ticker->url }}" class="announcement-item">{{ $ticker->text }}</a>
                @else
                    <span class="announcement-item">{{ $ticker->text }}</span>
                @endif
            @endforeach
        </div>
    </div>
@endif