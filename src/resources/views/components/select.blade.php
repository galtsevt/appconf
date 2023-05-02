<div class="mb-3">
    <label class="form-label fw-bold">{{ $labelName ?? '' }}:</label>
    <select class="form-select @error($name) is-invalid @enderror"
            name="{{ $name ?? '' }}"
    >
        <option value="" selected>{{ __('No select') }}</option>
        @foreach($data as $key => $value)
            <option value="{{ $key }}" {{ $key == settings($name, $group ?? null) ? 'selected':'' }}>{{ $value }}</option>
        @endforeach
    </select>

    @error($name)
    <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
    </span>
    @enderror
</div>
