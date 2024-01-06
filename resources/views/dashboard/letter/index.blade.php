@extends('dashboard.layouts.main')
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Bootstrap JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

@section('container')



<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Data Surat</h1>
</div>

<form class="d-flex col-lg-4" action="{{ route('letter.index') }}" method="GET" role="search">
    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="search">
    <button class="btn btn-outline-primary" type="submit">Search</button>
</form>

<nav aria-label="Pagination">
    <ul class="pagination">
        <li class="page-item {{ ($letters->onFirstPage()) ? 'disabled' : '' }}">
            <a class="page-link" href="{{ $letters->previousPageUrl() }}" tabindex="-1">Previous</a>
        </li>

        {{-- Loop untuk menampilkan tautan pagination --}}
        @for ($i = 1; $i <= $letters->lastPage(); $i++)
            <li class="page-item {{ ($letters->currentPage() == $i) ? 'active' : '' }}">
                <a class="page-link" href="{{ $letters->url($i) }}">{{ $i }}</a>
            </li>
            @endfor

            <li class="page-item {{ ($letters->currentPage() == $letters->lastPage()) ? 'disabled' : '' }}">
                <a class="page-link" href="{{ $letters->nextPageUrl() }}">Next</a>
            </li>
    </ul>
</nav>

@if(session()->has('success'))
<div class="alert alert-success col-lg-9" role="alert">
    {{ session('success') }}
</div>
@endif
<div class="table-responsive col-lg-9">
    @if (Auth::check())
    @if (Auth::user()->role == "staff")
    <a href="{{ route('letter.create') }}" class="btn btn-primary mb-3 mt-3">Tambah</a>
    <a href="{{ route('letter.exportExcel') }}" class="btn btn-primary">Export Data (excel)</a>
    @endif
    @endif
    <table class="table table-striped table-sm">

        <thead>
            <tr>
                <th scope="col">No</th>
                <th scope="col">Nomor Surat</th>
                <th scope="col">Perihal</th>
                <th scope="col">Tanggal Keluar</th>
                <th scope="col">Penerima Surat</th>
                <th scope="col">Notulis</th>
                <th scope="col">Hasil Rapat</th>
                <th scope="col" class="d-flex justify-content-center">Aksi</th>
            </tr>
        </thead>

        <tbody>
            
            @php $no = 1; @endphp
            @foreach ($letters as $letter)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $letter->letterType->letter_code }}</td>
                <td>{{ $letter->letter_perihal }}</td>
                {{-- <td>{{ $letter->created_at }}</td> --}}
                <td>{{ date('d F Y', strtotime($letter->created_at)) }}</td>
                <!-- Tampilkan nama notulis jika ada, atau tampilkan pesan alternatif jika tidak ditemukan -->
                {{-- Jika ingin menampilkan penerima surat, tambahkan logika yang serupa untuk recipients --}}
                <td>
                    @if($letter->recipients)
                    @foreach(json_decode($letter->recipients) as $recipientId)
                    {{ \App\Models\User::find($recipientId)->name }},
                    @endforeach
                    @else
                    Penerima Surat Tidak Ditemukan
                    @endif
                </td>
                {{-- <td>{{ $letter->notulisUser->name }}</td> <!-- Tampilkan nama notulis --> --}}
                <td>{{ $letter->notulisUser ? $letter->notulisUser->name : 'Notulis Tidak Ditemukan' }}</td>

                <td>
                    @if (Auth::check())
                    @if (Auth::user()->role == "guru")
                    @if ($letter->meeting_result)
                    <span class="btn btn-outline-primary">Sudah Dibuat</span>
                    @else
                    <a href="{{ route('result.create', ['letter_id' => $letter->id]) }}"
                        class="btn btn-outline-warning">Buat Hasil
                        Rapat</a>
                    @endif
                    @elseif (Auth::user()->role == "staff")
                    @if ($letter->meeting_result)
                    <span class="btn btn-outline-primary">Sudah Dibuat</span>
                    @else
                    <a href="{{ route('result.create', ['letter_id' => $letter->id]) }}"
                        class="btn btn-outline-warning">Buat Hasil
                        Rapat</a>
                    @endif
                    @endif
                    @endif
                </td>

              

                <td class="d-flex justify-content-center">
                    <a href="{{ route('letter.show', $letter->id) }}" class="btn btn-success me-3">Lihat</a>
                    @if (Auth::check())
                    @if (Auth::user()->role == "staff")
                    <a href="{{ route('letter.edit', $letter->id) }}" class="btn btn-primary me-3">Edit</a>
                    <button type="button" class="btn btn-danger delete-button" data-toggle="modal"
                        data-target="#deleteModal" data-id="{{ $letter->id }}">
                        Hapus
                    </button>
                    @endif
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>

    </table>


</div>
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
    $(document).ready(function () {
        $(".delete-button").click(function () {
            var id = $(this).data('id');
            $("#deleteForm").attr('action', '{{ route("letter.destroy", "") }}/' + id);
        });
    });


</script>
@endsection