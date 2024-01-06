@extends('dashboard.layouts.main')

@section('container')


<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Detail Surat</h1>
</div>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Bukti Pembelian</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        #header {

            display: flex;
            align-items: flex-start;
            /* flex-direction: column;  */
        }
        .card {
        width: 1000px;
        margin: 20px auto; /* Atur margin secara otomatis di sisi kiri dan kanan */
        }

        img {
            width: 120px;
            margin-right: 20px;
            /* Menyesuaikan jarak antara gambar dan teks */
        }

        #left-column {
            flex: 1;
        }

        #right-column {
            flex: 1;
        }
        #right-columns {
            flex: 1;
        }

        #left-column h2 {
            margin-top: 0;
            margin-bottom: 10px;
            border-bottom: 3px solid black;
            padding-bottom: 5px;
        }

        #left-column p {
            margin: 0;
        }

        #right-column p {
            margin: 5px;
            text-align: right;

        }
        #right-columns p {
            margin: 5px;
        }
        #right-columns{
            margin-left: 700px;
        }
      
    </style>
</head>

<body>
    <a href="{{ route('letter.index')}}" class="btn btn-dark">Kembali</a>
    <a href="{{ route('lettertyp.download', $letterType->id) }}" class="btn btn-dark">Cetak</a>
    <div class="card justify-content-center" style="width: 1000px; margin-bottom:20px;">
        <div class="card-body">
            <div id="header">
                    <img src="/img/wikrama-logo.png" alt="logo">
                    <div id="left-column">
                        <h2 style="margin-top: 15px;">SMK WIKRAMA BOGOR</h2>
                        <p>Bisnis dan Manajemen<br>Teknologi Informasi dan Komunikasi<br>Pariwisata</p>
                    </div>
                    <div id="right-column" style="margin-top: 15px; margin-right: 10px;">
                        <p>Jl. Raya Wangun Kel. Sindangsari Bogor</p>
                        <p>Telp/Faks:(0251)8242411</p>
                        <p>e-mail: prohumasi@smkwikrama.sch.id</p>
                        <p>website: www.smkwikrama.sch.id</p>
                    </div>
                </div>
                <br>
                <p style="border-bottom: 4px solid black; "></p> 
                <div class="content">
                    <br>
                    <p>Tanggal Keluar: {{ date('d F Y', strtotime($letters['created_at'])) }}</p>
                    <p>No: {{ $letters->letterType->letter_code }}</p>
                    <p>Klasifikasi Surat: {{ $letters->letterType->name_type }}</p>
                    <br>
                     <p>{!! $letters['content'] !!}</p>
                    <br>
                    <br>
                
                    <td>Notulis : {{ $letters->notulisUser ? $letters->notulisUser->name : 'Notulis Tidak Ditemukan' }}</td>
                    <br>
                    <td>
                        Penerima Surat : 
                        @if($letters->recipients)
                        @foreach(json_decode($letters->recipients) as $recipientId)
                        {{ \App\Models\User::find($recipientId)->name }},
                        @endforeach
                        @else
                        Penerima Surat Tidak Ditemukan
                        @endif
                    </td>
                
                
                
                    <br>
                    <br>
                    <div id="right-columns" >
                        <p >Hormat Kami,</p>
                        <p>Kepala SMK Wikrama Bogor</p>
                        <br>
                        <br>
                        <br>
                        <p>(...................................)</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card justify-content-center" style="width: 1000px; margin-bottom:20px; margin-left: 470px;
        }">
        <div class="card-body">
            <div class="mb-3">
                <label for="recipients" class="form-label">Peserta Rapat</label><br>
                @foreach($users as $user)
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="{{ $user->id }}" id="recipients{{ $user->id }}"
                        name="recipients[]" {{ in_array($user->id, json_decode($letters->recipients)) ? 'checked' : '' }}>
                    <label class="form-check-label" for="recipients{{ $user->id }}">
                        {{ $user->name }}
                    </label>
                </div>
                @endforeach
                <br>
                <br>
            </div>
            <br>
            <td>Notulis : {{ $letters->notulisUser ? $letters->notulisUser->name : 'Notulis Tidak Ditemukan' }}</td>
        </div>
    </div>
  


    
</div>
    
</body>

</html>

@endsection