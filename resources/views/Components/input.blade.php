@props([
    'name', 
    'label', 
    'type'        => 'text', 
    'value'       => '', 
    'placeholder' => '',
    'options'     => []
])

<div class="mb-3">
    <label for="{{ $name }}" class="form-label">
        {{ $label }}
    </label>

    @if($type === 'textarea')
        <textarea 
            name="{{ $name }}" 
            id="{{ $name }}" 
            placeholder="{{ $placeholder }}"
            {{ $attributes->merge(['class' => 'form-control ' . ($errors->has($name) ? 'is-invalid' : '')]) }}
        >{{ old($name, $value) }}</textarea>

    @elseif($type === 'file')
        <input 
            type="file" 
            name="{{ $name }}" 
            id="{{ $name }}" 
            {{ $attributes->merge(['class' => 'form-control ' . ($errors->has($name) ? 'is-invalid' : '')]) }}
        >
        @if($value)
            <div class="mt-2">
                <small class="text-muted">Current: {{ $value }}</small>
            </div>
        @endif

    @elseif($type === 'select')
        <select
            name="{{ $name }}"
            id="{{ $name }}"
            {{ $attributes->merge(['class' => 'form-select ' . ($errors->has($name) ? 'is-invalid' : '')]) }}
        >
            <option value="">-- Select --</option>
            @foreach($options as $key => $label)
                <option value="{{ $key }}" {{ old($name, $value) == $key ? 'selected' : '' }}>
                    {{ $label }}
                </option>
            @endforeach
        </select>

    @else
        <input 
            type="{{ $type }}" 
            name="{{ $name }}" 
            id="{{ $name }}" 
            value="{{ old($name, $value) }}" 
            placeholder="{{ $placeholder }}"
            {{ $attributes->merge(['class' => 'form-control ' . ($errors->has($name) ? 'is-invalid' : '')]) }}
        >
    @endif

    @error($name)
        <div class="invalid-feedback d-block">
            {{ $message }}
        </div>
    @enderror
</div>