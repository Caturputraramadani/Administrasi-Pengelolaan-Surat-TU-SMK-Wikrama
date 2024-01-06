@extends('dashboard.layouts.main')

@section('container')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-0 border-bottom">
    <h1 class="h2">Tambah Data Klasifikasi Surat <h1>
</div>
<div class="col-lg-8 mt-3">
    <form method="POST" action="{{ route('lettertyp.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="letter_code" class="form-label">Kode Surat</label>
            <input type="number" class="form-control" id="letter_code" name="letter_code">
        </div>
        <div class="mb-3">
            <label for="name_type" class="form-label">Klasifikasi Surat </label>
            <input type="text" class="form-control" id="name_type" name="name_type">
        </div>
        <button type="submit" class="btn btn-primary">Tambah</button>
    </form>
</div>
@endsection