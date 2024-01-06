<?php

namespace App\Http\Controllers;

use App\Models\LetterType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash; 
use PDF;

class LetterTypeController extends Controller
{

    public function index(Request $request)
    {
        $search = $request->input('search');
        // Query to fetch letter types based on search criteria
        $query = LetterType::with('letters');

        if (!empty($search)) {
            $query->where('letter_code', 'like', '%' . $search . '%')
                ->orWhere('name_type', 'like', '%' . $search . '%');
        }
        $letter_type = $query->simplePaginate(3);
        return view('dashboard.lettertyp.index', compact('letter_type'));
    }

    public function create()
    {
        return view('dashboard.lettertyp.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'letter_code' => 'required',
            'name_type' => 'required'
        ]);

        $letterType = LetterType::create([
            'letter_code' => $request->letter_code,
            'name_type' => $request->name_type,
        ]);

        // Menghitung ulang jumlah surat terkait setelah surat baru dibuat
        $letterType->letter_count = $letterType->letters()->count();
        $letterType->save();

        return redirect()->route('lettertyp.index')->with('success', 'Berhasil menambahkan data!');
    }


    public function show($id)
    {
        $letterType = LetterType::with('letters')->findOrFail($id);
        return view('dashboard.lettertyp.show', compact('letterType'));
    }

    public function edit(string $id)
    {
        $letter_type = LetterType::find($id);
        return view('dashboard.lettertyp.edit', compact('letter_type'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'letter_code' => 'required',
            'name_type' => 'required'
        ]);


        $LetterTypeData = [
            'letter_code' => $request->letter_code,
            'name_type' => $request->name_type,
        ];


        LetterType::where('id', $id)->update($LetterTypeData);

        return redirect()->route('lettertyp.index')->with('success', 'Berhasil mengubah data!');
    }

    public function destroy(string $id)
    {
        LetterType::where('id', $id)->delete();

        return redirect()->back()->with('deleted', 'Berhasil menghapus data!');
    }

    public function countOutgoingLetters()
    {
        $countSuratKlasi = LetterType::count();
        return $countSuratKlasi;
    }

    public function downloadPDF($id)
    {
        $letterType = LetterType::with('letters')->findOrFail($id);

        $letter = $letterType->letters->first(); // Mendapatkan data Letter yang terkait dengan LetterType

        $letter_type_array = [
            'created_at' => $letterType->created_at,
            'letter_code' => $letterType->letter_code,
            'name_type' => $letterType->name_type,
            'content' => $letter ? $letter->content : 'No content available', // Mengambil konten dari Letter yang terkait
            'recipientsUsers' => $letterType->recipientsUsers,
            'notulisUser' => $letter && $letter->notulisUser ? $letter->notulisUser->name : 'Notulis Tidak Ditemukan',

        ];

        view()->share('lettertyp', $letter_type_array);
        $pdf = PDF::loadView('dashboard.lettertyp.download', $letter_type_array);
        return $pdf->download('Surat.pdf');
    }


}
