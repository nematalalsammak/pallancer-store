<div class="form-group mb-3">
    <label for="">Name:</label>
    <input type="text" name="name" value="{{ old('name',$role->name) }}" class="form-control @error('name') is-invalid @enderror">
    @error('name')
    <p class="invalid-feedback">{{ $message }}</p>
    @enderror
</div>
<div class="form-group mb-3">
    <label for="">Abilities:</label>
    <div>
        @foreach(config('abilities') as $key =>$label)
        <div class="mb-1">
            <label for="">
                <input type="checkbox" name="abilities[]" value="{{ $key }}" @if(in_array($key,$role->abilities))checked @endif>
                {{ $label }}
            </label>
        </div>
        @endforeach
    </div>
    @error('abilities')
    <p class="invalid-feedback">{{ $message }}</p>
    @enderror
</div>
<div class="form-group">
    <button type="submit" class="btn btn-primary">{{ $button_lable ?? 'save'}}</button>
</div>
@push('css')
<link rel="stylesheet" href="{{ asset('js/tagify/tagify.css') }}">
@endpush

@push('js')
<script src="{{ asset('js/tagify/tagify.min.js') }}"></script>
<script>
    var inputElm = document.querySelector('.tagify'),
        tagify = new Tagify(inputElm);
</script>
@endpush