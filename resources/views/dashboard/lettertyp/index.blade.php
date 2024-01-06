@extends('dashboard.layouts.main')
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Bootstrap JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

@section('container')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Data Klasifikasi Surat</h1>
</div>

@if(session()->has('success'))
<div class="alert alert-success col-lg-9" role="alert">
    {{ session('success') }}
</div>
@endif

<form class="d-flex col-lg-4" action="{{ route('lettertyp.index') }}" method="GET" role="search">
    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="search">
    <button class="btn btn-outline-primary" type="submit">Search</button>
</form>

<div class="d-flex justify-content-start">
    {{-- {{ jika data ada atau > 0 }} --}}
    @if ( $letter_type->count())
    {{-- munculkan tampilan pagination --}}
    {{ $letter_type->links() }}
    @endif
</div>

<div class="table-responsive col-lg-9">
    <a href="{{ route('lettertyp.create') }}" class="btn btn-primary mb-3 mt-3">Tambah</a>
    <a href="{{ route('users.export-excel') }}" class="btn btn-primary">Export Data (excel)</a>
    <table class="table table-striped table-sm">
        <thead>
            <tr>
                <th scope="col">No</th>
                <th scope="col">Kode Surat</th>
                <th scope="col">Klasifikasi Surat</th>
                <th scope="col">Surat Tertaut</th>
                <th scope="col" class="d-flex justify-content-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @php $no = 1; @endphp
            @foreach ($letter_type as $lty)
            <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $lty->letter_code }}</td>
                <td>{{ $lty->name_type }}</td>
                <td>{{ $lty->letter_count }}</td>
                <td class="d-flex justify-content-center">
                    <a href="{{ route('lettertyp.show', $lty['id']) }}" class="btn btn-success me-3">Lihat</a>
                    <a href="{{ route('lettertyp.edit', $lty['id']) }}" class="btn btn-primary me-3">Edit</a>
                    <button type="button" class="btn btn-danger delete-button" data-toggle="modal"
                        data-target="#deleteModal" data-id="{{ $lty['id'] }}">
                        Hapus
                    </button>
                </td>
            </tr>
        </tbody>
        @endforeach
    </table>

</div>


<!-- Bootstrap Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    {{-- <span aria-hidden="true">&times;</span> --}}
                </button>
            </div>
            <div class="modal-body">
                Apakah Anda yakin ingin menghapus Data ini?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <form id="deleteForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // JavaScript to handle the delete button click event
    $(document).ready(function () {
        $(".delete-button").click(function () {
            var id = $(this).data('id');
            $("#deleteForm").attr('action', '{{ route("lettertyp.destroy", "") }}/' + id);
        });
    });
</script>
@endsection