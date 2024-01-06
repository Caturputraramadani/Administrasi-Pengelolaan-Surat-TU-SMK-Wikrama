@extends('dashboard.layouts.main')



@section('container')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Dashboard </h1>
</div>

<div class="d-flex justify-content-between flex-wrap " style="margin-top:50px;">
    
    <div class="card text-bg-light mb-3" style="width: 40rem; ">
        <div class="card-body">
            <h5 class="card-title">Surat Keluar</h5>
            <div class="d-flex justify-content-between flex-wrap">
                <div class="icon-content">
                    <i class="bi bi-newspaper" style="font-size: 4rem;"></i>
                </div>
                <h4 style="font-size: 3rem; margin-right:500px; margin-top:25px;">
                    <?php
                        $letterController = new App\Http\Controllers\LetterController();
                        echo $letterController->countOutgoingLetters();
                    ?>
                </h4>
            </div>
        </div>
    </div>
    @if (Auth::check())
    @if (Auth::user()->role == "staff")
    <div class="card text-bg-light mb-3" style="width: 18rem; margin-right: 130px;">
        <div class="card-body">
            <h5 class="card-title">Surat Keluar</h5>
            <div class="d-flex justify-content-between flex-wrap">
                <div class="icon-content">
                    <i class="bi bi-newspaper" style="font-size: 4rem;"></i>
                </div>
                <h4 style="font-size: 3rem; margin-right:150px; margin-top:25px;">
                    <?php
                        $letterControllertyp = new App\Http\Controllers\LetterTypeController();
                        echo $letterControllertyp->countOutgoingLetters();
                    ?>
                </h4>
            </div>
        </div>
    </div>
    <div class="card text-bg-light mb-3" style="width: 18rem;">
        <div class="card-body">
            <h5 class="card-title">Staff Tata Usaha</h5>
            <div class="d-flex justify-content-between flex-wrap align-items-center">
                <div class="icon-content">
                    <i class="bi bi-people-fill" style="font-size: 4rem;"></i>
                </div>
                <h4 style="font-size: 3rem; margin-right:150px; margin-top: 20px;">
                    <?php
                        $userController = new App\Http\Controllers\UserController();
                        echo $userController->countStaff();
                    ?>
                </h4>
            </div>
        </div>
    </div>
    <div class="card text-bg-light mb-3" style="width: 40rem; margin-right: 130px;">
        <div class="card-body">
            <h5 class="card-title">Guru</h5>
            <div class="d-flex justify-content-between flex-wrap align-items-center">
                <div class="icon-content">
                    <i class="bi bi-people-fill" style="font-size: 4rem;"></i>
                </div>
                <h4 style="font-size: 3rem; margin-right:500px; margin-top: 25px;">
                    <?php
                    echo $userController->countGuru();
                ?>
                </h4>
            </div>
        </div>
    </div>
    @endif
    @endif
</div>
@endsection