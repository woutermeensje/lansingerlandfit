<footer class="bg-navy-900 text-navy-100">
    <div class="container-site grid gap-10 py-14 md:grid-cols-4">
        <div>
            <p class="font-display text-2xl font-extrabold text-white">Lansingerland<span class="text-mint-400">fit</span>.nl</p>
            <p class="mt-3 text-sm leading-relaxed text-navy-100/80">{{ config('site.tagline') }}</p>
        </div>

        <div>
            <h2 class="text-xs font-semibold uppercase tracking-[0.2em] !text-mint-400">Informatie</h2>
            <ul class="mt-4 space-y-2 text-sm">
                <li><a class="hover:text-white" href="{{ route('contact') }}">Aanmelden</a></li>
                <li><a class="hover:text-white" href="{{ route('lesrooster') }}">Lesrooster</a></li>
                <li><a class="hover:text-white" href="{{ route('tarieven') }}">Tarieven</a></li>
                <li><a class="hover:text-white" href="{{ route('blogs') }}">Blogs</a></li>
            </ul>
        </div>

        <div>
            <h2 class="text-xs font-semibold uppercase tracking-[0.2em] !text-mint-400">Trainingen</h2>
            <ul class="mt-4 space-y-2 text-sm">
                @foreach (config('site.trainings') as $slug => $training)
                    <li><a class="hover:text-white" href="{{ route('training', $slug) }}">{{ $training['title'] }}</a></li>
                @endforeach
            </ul>
        </div>

        <div>
            <h2 class="text-xs font-semibold uppercase tracking-[0.2em] !text-mint-400">Over ons</h2>
            <ul class="mt-4 space-y-2 text-sm">
                <li>{{ config('site.contact.person') }}</li>
                <li><a class="hover:text-white" href="tel:{{ preg_replace('/\D/', '', config('site.contact.phone')) }}">{{ config('site.contact.phone') }}</a></li>
                <li><a class="hover:text-white" href="mailto:{{ config('site.contact.email') }}">{{ config('site.contact.email') }}</a></li>
                <li><a class="hover:text-white" href="{{ route('over-ons') }}">Over mij</a></li>
            </ul>
        </div>
    </div>
    <div class="border-t border-white/10">
        <div class="container-site flex flex-col gap-2 py-6 text-xs text-navy-100/60 sm:flex-row sm:justify-between">
            <p>&copy; {{ date('Y') }} {{ config('site.name') }}</p>
            <p>Buiten sporten in {{ implode(', ', array_slice(config('site.regions'), 0, -1)) }} en {{ last(config('site.regions')) }}</p>
        </div>
    </div>
</footer>
