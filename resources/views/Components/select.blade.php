@props([
    'name', 
    'label', 
    'options' => [], 
    'selected' => null
])

<div class="mb-3">
    <label for="{{ $name }}" class="form-label">{{ $label }}</label>
    <select 
        name="{{ $name }}" 
        id="{{ $name }}" 
        {{ $attributes->merge(['class' => 'form-select ' . ($errors->has($name) ? 'is-invalid' : '')]) }}
    >
        <option value="">-- Select {{ $label }} --</option>
        @foreach($options as $key => $val)
            <option value="{{ $key }}" {{ old($name, $selected) == $key ? 'selected' : '' }}>
                {{ $val }}
            </option>
        @endforeach
    </select>

    @error($name)
        <div class="invalid-feedback d-block">
            {{ $message }}
        </div>
    @enderror
</div>