@props([
    'name', 
    'label', 
    'options' => [], 
    'selected' => null, 
    'inline' => true
])

<div class="mb-3">
    <label class="form-label d-block">{{ $label }}</label>
    
    @foreach($options as $value => $display)
        <div class="form-check {{ $inline ? 'form-check-inline' : '' }}">
            <input 
                class="form-check-input @error($name) is-invalid @enderror" 
                type="radio" 
                name="{{ $name }}" 
                id="{{ $name . '_' . $value }}" 
                value="{{ $value }}"
                {{ old($name, $selected) == $value ? 'checked' : '' }}
                {{ $attributes }}
            >
            <label class="form-check-label" for="{{ $name . '_' . $value }}">
                {{ $display }}
            </label>
        </div>
    @endforeach

    @error($name)
        <div class="text-danger small d-block">{{ $message }}</div>
    @enderror
</div>