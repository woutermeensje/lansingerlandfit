<x-layouts.app>
    <x-page-hero eyebrow="Lesrooster" title="Lesrooster groepstrainingen" intro="Alle groepslessen vinden buiten plaats. Kies een les en meld je direct aan." />

    <section class="container-site py-12">
        <x-schedule :days="$days" />
    </section>
</x-layouts.app>
