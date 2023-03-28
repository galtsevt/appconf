<div class="mb-3">
    <label class="form-label fw-bold">{{ $labelName ?? '' }}:</label>
    <textarea placeholder="{{ $placeholder ?? '' }}" id="{{ $id ?? '' }}"
              class="form-control {{ $class ?? '' }} @error($name) is-invalid @enderror"
              name="{{ $name ?? '' }}"
              rows="3">{!! $value ?? '' !!}</textarea>
    @error($name)
    <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
    </span>
    @enderror
</div>
