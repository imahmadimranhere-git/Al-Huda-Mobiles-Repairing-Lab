@if ($banners->isNotEmpty())
    <div class="banner-slider" id="bannerSlider">
        <div class="banner-slider-track">
            @foreach ($banners as $banner)
                @php
                    $slide = '
                        <picture>
                            <source media="(max-width: 576px)" srcset="' . asset('storage/' . $banner->image_mobile) . '">
                            <source media="(max-width: 991px)" srcset="' . asset('storage/' . $banner->image_tablet) . '">
                            <img src="' . asset('storage/' . $banner->image_desktop) . '" alt="' . e($banner->title) . '" class="banner-slide-img">
                        </picture>
                    ';
                @endphp
                <div class="banner-slide">
                    @if ($banner->url)
                        <a href="{{ $banner->url }}">{!! $slide !!}</a>
                    @else
                        {!! $slide !!}
                    @endif
                </div>
            @endforeach
        </div>

        @if ($banners->count() > 1)
            <div class="banner-slider-dots">
                @foreach ($banners as $index => $banner)
                    <button type="button" class="banner-dot {{ $index === 0 ? 'active' : '' }}" data-slide="{{ $index }}"></button>
                @endforeach
            </div>
        @endif
    </div>

    @if ($banners->count() > 1)
        <script>
            (function () {
                const slider = document.getElementById('bannerSlider');
                const track = slider.querySelector('.banner-slider-track');
                const dots = slider.querySelectorAll('.banner-dot');
                const total = {{ $banners->count() }};
                let current = 0;

                function goTo(index) {
                    current = index;
                    track.style.transform = 'translateX(-' + (index * 100) + '%)';
                    dots.forEach((dot, i) => dot.classList.toggle('active', i === index));
                }

                dots.forEach((dot, i) => dot.addEventListener('click', () => goTo(i)));

                setInterval(function () {
                    goTo((current + 1) % total);
                }, 4000);
            })();
        </script>
    @endif
@endif