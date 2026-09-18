@php
    $footerLogo = \App\Models\SiteSetting::get('site_logo');
    $footerPhone = \App\Models\SiteSetting::get('contact_phone');
    $footerWhatsapp = \App\Models\SiteSetting::get('contact_whatsapp');
    $footerEmail = \App\Models\SiteSetting::get('contact_email');
    $footerAddress = \App\Models\SiteSetting::get('contact_address');
    $footerFb = \App\Models\SiteSetting::get('social_facebook');
    $footerIg = \App\Models\SiteSetting::get('social_instagram');
    $footerYt = \App\Models\SiteSetting::get('social_youtube');

    $footerCategories = \App\Models\Category::where('is_active', true)->orderBy('name')->limit(5)->get();
    $footerServices = \App\Models\Service::where('is_active', true)->orderBy('display_order')->limit(5)->get();
@endphp

<footer class="site-footer-dark">
    <div class="footer-inner">
        <div class="container">

            <div class="row g-4 footer-main">

                {{-- Brand Column --}}
                <div class="col-lg-4 col-md-6">
                    <div class="footer-brand">
                        @if ($footerLogo)
                            <img src="{{ asset('storage/' . $footerLogo) }}" alt="Al Huda Mobiles Repairing Lab" class="footer-logo">
                        @else
                            <h5 class="footer-brand-name">Al Huda Mobiles Repairing Lab</h5>
                        @endif
                    </div>

                    <p class="footer-tagline">
                        Professional mobile repairing lab and accessories shop. Genuine parts,
                        expert technicians, and same-day service you can trust.
                    </p>

                    @if ($footerFb || $footerIg || $footerYt)
                        <div class="footer-social">
                            @if ($footerFb)
                                <a href="{{ $footerFb }}" target="_blank" rel="noopener" aria-label="Facebook">
                                    <i class="bi bi-facebook"></i>
                                </a>
                            @endif
                            @if ($footerIg)
                                <a href="{{ $footerIg }}" target="_blank" rel="noopener" aria-label="Instagram">
                                    <i class="bi bi-instagram"></i>
                                </a>
                            @endif
                            @if ($footerYt)
                                <a href="{{ $footerYt }}" target="_blank" rel="noopener" aria-label="YouTube">
                                    <i class="bi bi-youtube"></i>
                                </a>
                            @endif
                        </div>
                    @endif
                </div>

                {{-- Contact Column --}}
                <div class="col-lg-3 col-md-6">
                    <h6 class="footer-col-title">Get in Touch</h6>

                    <ul class="footer-contact-list">
                        @if ($footerPhone)
                            <li>
                                <span class="footer-icon"><i class="bi bi-telephone-fill"></i></span>
                                <a href="tel:{{ preg_replace('/\s+/', '', $footerPhone) }}">{{ $footerPhone }}</a>
                            </li>
                        @endif
                        @if ($footerWhatsapp)
                            <li>
                                <span class="footer-icon"><i class="bi bi-whatsapp"></i></span>
                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $footerWhatsapp) }}" target="_blank" rel="noopener">
                                    {{ $footerWhatsapp }}
                                </a>
                            </li>
                        @endif
                        @if ($footerEmail)
                            <li>
                                <span class="footer-icon"><i class="bi bi-envelope-fill"></i></span>
                                <a href="mailto:{{ $footerEmail }}">{{ $footerEmail }}</a>
                            </li>
                        @endif
                        @if ($footerAddress)
                            <li>
                                <span class="footer-icon"><i class="bi bi-geo-alt-fill"></i></span>
                                <span>{{ $footerAddress }}</span>
                            </li>
                        @endif
                    </ul>
                </div>

                {{-- Shop Column — first 5 categories, NO "See All" --}}
                <div class="col-lg-2 col-md-6 col-6">
                    <h6 class="footer-col-title">Shop</h6>
                    <ul class="footer-links">
                        @forelse ($footerCategories as $category)
                            <li>
                                <a href="{{ route('shop.index', ['category' => $category->id]) }}">
                                    {{ $category->name }}
                                </a>
                            </li>
                        @empty
                            <li><a href="{{ route('shop.index') }}">All Products</a></li>
                        @endforelse
                    </ul>
                </div>

                {{-- Services Column — first 5 services, NO "See All" --}}
                <div class="col-lg-3 col-md-6 col-6">
                    <h6 class="footer-col-title">Services</h6>
                    <ul class="footer-links">
                        @forelse ($footerServices as $service)
                            <li>
                                <a href="{{ route('home') }}#services">{{ $service->title }}</a>
                            </li>
                        @empty
                            <li><a href="{{ route('home') }}#services">Our Services</a></li>
                        @endforelse
                    </ul>
                </div>

            </div>

            <hr class="footer-divider">

            <div class="footer-bottom">
                <p class="footer-copyright">
                    &copy; {{ date('Y') }} Al Huda Mobiles Repairing Lab. All rights reserved.
                </p>
                <div class="footer-bottom-links">
                    <a href="{{ route('home') }}">Home</a>
                    <span>•</span>
                    <a href="{{ route('orders.index') }}">My Orders</a>
                    <span>•</span>
                    <a href="{{ route('news.index') }}">News</a>
                </div>
            </div>

        </div>
    </div>
</footer>