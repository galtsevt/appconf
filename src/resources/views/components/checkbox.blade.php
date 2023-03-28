<div class="form-check">
    <input name="{{ $name ?? '' }}" class="form-check-input" type="checkbox" value="{{ $value ?? '' }}"
           id="check_{{ $name ?? '' }}" {{ $checked ? 'checked':null }}>
    <label class="form-check-label" for="check_{{ $name ?? '' }}">
        {{ $labelName ?? 'checkbox' }}
    </label>
</div>
@error($name)
<span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
</span>
@enderror
