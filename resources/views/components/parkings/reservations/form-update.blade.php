
@props(['type' => 'text', 'name', 'value' => '', 'label', 'error' => null])

<div class="form-group">
    <label for="{{ $name }}">{{ $label }}</label>
    <input type="{{ $type }}" class="form-control {{ $error ? 'is-invalid' : '' }}" id="{{ $name }}" name="{{ $name }}" value="{{ $value }}">
    @if ($error)
        <span class="invalid-feedback" role="alert">
            <strong>{{ $error }}</strong>
        </span>
    @endif
</div>
