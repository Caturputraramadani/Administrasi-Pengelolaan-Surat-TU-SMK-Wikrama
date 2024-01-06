@extends('dashboard.layouts.main')

@section('container')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-0 border-bottom">
    <h1 class="h2">Edit Data Staff Tata Usaha <h1>
</div>
<div class="col-lg-8 mt-3">
    <form method="POST" action="{{ route('users.updateSt', $users['id']) }}" enctype="multipart/form-data">
        @csrf
        @method('PATCH')
        
        {{-- @if($errors->any())
        <ul class="alert alert-danger p-3">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
        @endif --}}

        <div class="mb-3">
            <label for="name" class="form-label">Nama :</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $users['name'] }}">
        </div>
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Email :</label>
            <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="email" value="{{ $users['email'] }}">
        </div>
        <div class="mb-3 row">
            <label for="password" class="form-label">Ubah Password :</label>
            <div class="col-sm-10">
                <input type="password" class="form-control" id="password" name="password" >
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Edit</button>
    </form>
</div>
@endsection