<x-layouts.app>
    <x-page-hero eyebrow="Contact" title="Contact opnemen?" intro="Laat hier je gegevens en vraag achter en ik neem snel contact met je op!" />

    <section class="container-site grid gap-10 py-12 lg:grid-cols-[3fr_2fr]">
        <div class="card p-6 sm:p-8">
            <x-contact-form :interest="$interest" />
        </div>

        <aside class="space-y-6">
            <div class="rounded-base bg-navy-700 p-8 text-white">
                <h2 class="text-2xl !text-white">Of onze directe contactgegevens:</h2>
                <dl class="mt-6 space-y-4 text-sm">
                    <div>
                        <dt class="text-navy-100">Trainer</dt>
                        <dd class="text-base font-semibold">{{ config('site.contact.person') }}</dd>
                    </div>
                    <div>
                        <dt class="text-navy-100">Telefoon</dt>
                        <dd><a href="tel:{{ preg_replace('/\D/', '', config('site.contact.phone')) }}" class="text-base font-semibold hover:text-mint-400">{{ config('site.contact.phone') }}</a></dd>
                    </div>
                    <div>
                        <dt class="text-navy-100">E-mail</dt>
                        <dd><a href="mailto:{{ config('site.contact.email') }}" class="text-base font-semibold hover:text-mint-400">{{ config('site.contact.email') }}</a></dd>
                    </div>
                </dl>
            </div>
            <div class="card p-8">
                <h2 class="text-xl">Liever eerst proberen?</h2>
                <p class="mt-2 text-sm text-gray-600">Je eerste groepsles is altijd gratis.</p>
                <a href="{{ route('proefles') }}" class="btn btn-primary mt-5">Gratis proefles</a>
            </div>
        </aside>
    </section>
</x-layouts.app>
