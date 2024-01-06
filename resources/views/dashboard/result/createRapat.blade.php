@extends('dashboard.layouts.main')

@section('container')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Buat Hasil Rapat</h1>
</div>

<div class="col-lg-6">
    <form action="{{ route('result.store') }}" method="POST">
        @csrf
        <input type="hidden" name="letter_id" value="{{ $letterId }}">

        <div class="mb-3">
            <label for="recipients" class="form-label">Peserta Rapat</label><br>
            @foreach($users as $user)
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="{{ $user->id }}" id="recipients{{ $user->id }}"
                    name="recipients[]">
                <label class="form-check-label" for="recipients{{ $user->id }}">
                    {{ $user->name }}
                </label>
            </div>
            @endforeach
        </div>
        <div class="mb-3">
            <label for="notes" class="form-label">Ringkasan</label>
            <input id="notes" type="hidden" name="notes" value="{{ old('notes') }}">
            <trix-editor input="notes"></trix-editor>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>
@endsection