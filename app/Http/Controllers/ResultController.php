<?php

namespace App\Http\Controllers;

use App\Models\Result;
use App\Models\User;
use App\Models\Letter;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ResultController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $results = Result::with('letter')->get();
        return view('dashboard.letter.detail', compact('results'));
    }

    /**
     * Show the form for creating a new resource.
     */
     public function create()
    {
    $letterId = 123; 
    $users = User::where('role', 'guru')->get();
    return view('dashboard.result.createRapat', compact('users', 'letterId'));
    }



    public function store(Request $request)
    {
        // Validasi request

        // ...

        $result = new Result([
            'letter_id' => $request->input('letter_id'),
            'notes' => $request->input('notes'),
            'presence_recipients' => json_encode($request->recipients),
        ]);
        $result->save();

        // Logika untuk memperbarui status meeting_result pada tabel 'letters'
        $letter = Letter::find($request->input('letter_id'));
        if ($letter && Auth::user()->role === 'guru') {
            $letter->meeting_result = true;
            $letter->save();
        }

        // Redirect ke halaman detail dengan menyertakan ID surat untuk menampilkan hasilnya
        return redirect()->route('letter.index')->with('success', 'Hasil rapat berhasil disimpan.');
    }





    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Ambil data surat berdasarkan ID
        $letter = Letter::findOrFail($id);
        
        // Ambil data users untuk peserta rapat
        $users = User::where('role', 'guru')->get();
        
        // Kirim data surat dan users ke view
        return view('dashboard.letter.index', compact('letter', 'users'));
    }   








}
