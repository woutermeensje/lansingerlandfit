@props(['name', 'label', 'hint' => null])

<div {{ $attributes->merge(['class' => 'admin-field']) }}>
    <label for="{{ $name }}" class="form-label">{{ $label }}</label>
    {{ $slot }}
    @if ($hint)
        <p class="form-hint">{{ $hint }}</p>
    @endif
    @error($name)
        <p class="form-field-error">{{ $message }}</p>
    @enderror
</div>
