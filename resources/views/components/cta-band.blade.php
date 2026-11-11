@unless (request()->routeIs('proefles', 'contact'))
    <section class="container-site py-16">
        <div class="relative overflow-hidden rounded-[2rem] bg-navy-700 px-6 py-12 text-center sm:px-12 sm:py-16">
            <div class="absolute -right-16 -top-16 size-56 rounded-full bg-mint-500/25" aria-hidden="true"></div>
            <div class="absolute -bottom-20 -left-10 size-64 rounded-full bg-mint-500/15" aria-hidden="true"></div>
            <div class="relative">
                <h2 class="text-3xl !text-white sm:text-4xl">Zin om een keer mee te trainen?</h2>
                <p class="mx-auto mt-4 max-w-xl text-navy-100">Plan vrijblijvend een gratis proefles en ervaar hoe fijn het is om buiten te sporten.</p>
                <div class="mt-8 flex flex-wrap justify-center gap-3">
                    <a href="{{ route('proefles') }}" class="btn btn-primary">Gratis proefles</a>
                    <a href="{{ route('lesrooster') }}" class="btn btn-light">Bekijk lesrooster</a>
                </div>
            </div>
        </div>
    </section>
@endunless
