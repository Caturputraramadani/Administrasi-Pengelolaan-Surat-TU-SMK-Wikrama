    @extends('dashboard.layouts.main')

    @section('container')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-0 border-bottom">
        <h1 class="h2">Tambah Data Surat<h1>
    </div>
    
    <div class="col-lg-8">
        <form method="POST" action="{{ route('letter.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="letter_perihal" class="form-label">Perihal</label>
                <input type="text" class="form-control @error('letter_perihal') is-invalid @enderror" id="letter_perihal"
                    name="letter_perihal" required autofocus value="{{ old('letter_perihal') }}">
            </div>


            <div class="mb-3">
                <label for="slug" class="form-label">Klasifikasi Surat :</label>
                <select class="form-select" aria-label="Default select example" name="letter_type_id">
                    <option selected>Pilih</option>
                    @foreach($letters as $lt)
                    <option value="{{ $lt->id }}">{{ $lt->name_type }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="content" class="form-label">Isi Surat</label>
                {{-- @error('content')
                <p class="text-danger">{{ $message }}</p>
                @enderror --}}
                <input id="content" type="hidden" name="content" value="{{ old('content') }}">
                <trix-editor input="content"></trix-editor>
            </div>

            {{-- <div class="mb-3">
                <label for="image" class="form-label">Lampiran</label>
                <img src="" class="img-preview img-fluid mb-3" id="frame" style="max-height: 500px; overflow:hidden">
                <input class="form-control " type="file" id="attachment" name="attachment" onchange="preview()">
            </div> --}}

            <div class="mb-3">
                <label for="recipients" class="form-label">Peserta Rapat</label><br>
                @foreach($users as $user)
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="{{ $user->id }}" id="recipients{{ $user->id }}"
                        name="recipients[]"> <!-- Tambahkan [] untuk menyimpan nilai sebagai array -->
                    <label class="form-check-label" for="recipients{{ $user->id }}">
                        {{ $user->name }}
                    </label>
                </div>
                @endforeach
            </div>

            <div class="mb-3">
                <label for="notulis" class="form-label">Notulis</label>
                <select class="form-select" id="notulis" name="notulis" required>
                    <option selected>Pilih Notulis</option>
                    @foreach($users as $user)
                    @if($user->role === 'guru')
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endif
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Tambah</button>
        </form>
    </div>


    @endsection