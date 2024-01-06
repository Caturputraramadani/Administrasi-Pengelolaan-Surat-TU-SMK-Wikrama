@extends('dashboard.layouts.main')

@section('container')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Detail Klasifikasi Surat</h1>
</div>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h4">{{ $letterType->letter_code }} | <span <h6 class="card-subtitle mb-2 text-body-secondary">{{
            $letterType->name_type }}</span></h1>
</div>

@if ($letterType->letter_count > 0)
<div class="d-flex flex-wrap">
    @foreach ($letterType->letters as $letter)
    <div class="card m-2" style="width: 18rem;">
        <div class="card-body">
            <a href="{{ route('lettertyp.download', $letterType->id) }}" class="btn btn-primary me-3 mb-3"><i
                    class="bi bi-download"></i></a>
            <h4>{{ date('d F Y', strtotime($letter->created_at)) }}</h4>
            <h5>Penerima Surat:</h5>
            <ul>
                {{-- kode penerima surat --}}
                @if($letter->notulisUser)
                {{ $letter->notulisUser->name }}
                @else
                Penerima Tidak Ditemukan
                @endif
            </ul>
            <!-- Tambahkan informasi lain yang diperlukan dari $letter -->
        </div>
    </div>
    @endforeach
</div>
@else
<p>Tidak ada surat tertaut.</p>
@endif

@endsection