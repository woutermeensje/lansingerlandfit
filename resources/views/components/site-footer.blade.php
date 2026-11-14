@php
    $phone = config('site.contact.phone');
    $regions = config('site.regions');
@endphp

<footer class="site-footer">
    <div class="site-footer__inner">
        <div class="site-footer__column">
            <h2 class="site-footer__heading">Over ons</h2>
            <p class="site-footer__text">{{ config('site.tagline') }}</p>
        </div>

        <div class="site-footer__column">
            <h2 class="site-footer__heading">Informatie</h2>
            <ul class="site-footer__links">
                <li><a href="{{ route('proefles') }}">Gratis proefles</a></li>
                <li><a href="{{ route('lesrooster') }}">Lesrooster</a></li>
                <li><a href="{{ route('tarieven') }}">Tarieven</a></li>
                <li><a href="{{ route('blogs') }}">Blogs</a></li>
                <li><a href="{{ route('afval-begeleiding') }}">Afvalbegeleiding</a></li>
                <li><a href="{{ route('voedings-advies') }}">Voedingsadvies</a></li>
                <li><a href="{{ route('caloriebehoefte-calculator') }}">Caloriebehoefte calculator</a></li>
                <li><a href="{{ route('sportparken') }}">Sportparken Lansingerland</a></li>
            </ul>
        </div>

        <div class="site-footer__column">
            <h2 class="site-footer__heading">Trainingen</h2>
            <ul class="site-footer__links">
                @foreach (config('site.trainings') as $slug => $training)
                    <li><a href="{{ route('training', $slug) }}">{{ $training['title'] }}</a></li>
                @endforeach
            </ul>
        </div>

        <div class="site-footer__column">
            <h2 class="site-footer__heading">Contact</h2>
            <ul class="site-footer__links">
                <li><span>{{ config('site.contact.person') }}</span></li>
                <li><a href="tel:{{ preg_replace('/\D/', '', $phone) }}">{{ $phone }}</a></li>
                <li><a href="mailto:{{ config('site.contact.email') }}">{{ config('site.contact.email') }}</a></li>
                <li><a href="{{ route('over-ons') }}">Over mij</a></li>
            </ul>
        </div>
    </div>

    <div class="site-footer__bottom">
        <span>&copy; {{ date('Y') }} {{ config('site.name') }} &middot; <a href="{{ route('sitemap') }}">Sitemap</a></span>
        <span>Buiten sporten in {{ implode(', ', array_slice($regions, 0, -1)) }} en {{ last($regions) }}</span>
    </div>
</footer>
