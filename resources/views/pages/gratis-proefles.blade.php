<x-layouts.app title="Gratis proefles" description="Plan een gratis proefles bij Lansingerlandfit.nl en train een keer vrijblijvend mee in de buitenlucht.">
    <x-page-hero eyebrow="Gratis proefles" title="Train een keer gratis mee" intro="Ervaar zelf hoe fijn het is om buiten te sporten. Laat je gegevens achter, dan plannen we samen een proefles in." />

    <section class="container-site grid gap-10 py-12 lg:grid-cols-[3fr_2fr]">
        <div class="card p-6 sm:p-8">
            <x-contact-form source="proefles" interest="Gratis proefles" :show-interest="false" submit="Proefles aanvragen" />
        </div>
        <aside class="card h-fit p-8">
            <h2 class="text-xl">Zo werkt het</h2>
            <ol class="mt-6 space-y-5 text-sm">
                @foreach (['Vul het formulier in en vertel welke training je wilt proberen.', 'Ik neem contact met je op en we kiezen samen een les en locatie.', 'Je traint gratis en vrijblijvend mee. Neem alleen goede schoenen en water mee!'] as $i => $step)
                    <li class="flex gap-4">
                        <span class="flex size-8 shrink-0 items-center justify-center rounded-full bg-mint-500 font-bold text-white">{{ $i + 1 }}</span>
                        <span class="pt-1 text-gray-700">{{ $step }}</span>
                    </li>
                @endforeach
            </ol>
        </aside>
    </section>
</x-layouts.app>
