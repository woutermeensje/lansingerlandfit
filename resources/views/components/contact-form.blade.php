@props(['source' => 'contact', 'interest' => null, 'showInterest' => true, 'submit' => 'Verstuur'])

<form method="POST" action="{{ route('contact.store') }}" {{ $attributes->merge(['class' => 'space-y-5']) }}>
    @csrf
    <input type="hidden" name="source" value="{{ $source }}">
    <div class="hidden" aria-hidden="true">
        <label>Website <input type="text" name="website" tabindex="-1" autocomplete="off"></label>
    </div>

    @if ($errors->hasAny(['first_name', 'last_name', 'email', 'phone', 'interest', 'message']))
        <div class="rounded-base bg-red-50 p-4 text-sm text-red-700">
            <p class="font-semibold">Controleer de gemarkeerde velden.</p>
        </div>
    @endif

    <div class="grid gap-5 sm:grid-cols-2">
        @foreach (['first_name' => ['Voornaam', 'given-name'], 'last_name' => ['Achternaam', 'family-name']] as $field => [$label, $auto])
            <div>
                <label for="{{ $source }}-{{ $field }}" class="form-label">{{ $label }} <span class="text-mint-600">*</span></label>
                <input id="{{ $source }}-{{ $field }}" name="{{ $field }}" value="{{ old($field) }}" required autocomplete="{{ $auto }}" class="form-input @error($field) !border-red-400 @enderror">
                @error($field) <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>
        @endforeach
        <div>
            <label for="{{ $source }}-email" class="form-label">E-mail <span class="text-mint-600">*</span></label>
            <input id="{{ $source }}-email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email" class="form-input @error('email') !border-red-400 @enderror">
            @error('email') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
        </div>
        <div>
            <label for="{{ $source }}-phone" class="form-label">Telefoonnummer</label>
            <input id="{{ $source }}-phone" type="tel" name="phone" value="{{ old('phone') }}" autocomplete="tel" class="form-input @error('phone') !border-red-400 @enderror">
            @error('phone') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
        </div>
    </div>

    @if ($showInterest)
        <div>
            <label for="{{ $source }}-interest" class="form-label">Waar heb je interesse in?</label>
            <select id="{{ $source }}-interest" name="interest" class="form-input">
                <option value="">Maak een keuze</option>
                @foreach (config('site.interests') as $option)
                    <option value="{{ $option }}" @selected(old('interest', $interest) === $option)>{{ $option }}</option>
                @endforeach
            </select>
            @error('interest') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
        </div>
    @elseif ($interest)
        <input type="hidden" name="interest" value="{{ $interest }}">
    @endif

    <div>
        <label for="{{ $source }}-message" class="form-label">Bericht</label>
        <textarea id="{{ $source }}-message" name="message" rows="5" class="form-input @error('message') !border-red-400 @enderror">{{ old('message') }}</textarea>
        @error('message') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
    </div>

    <button type="submit" class="btn btn-primary">{{ $submit }}</button>
</form>
