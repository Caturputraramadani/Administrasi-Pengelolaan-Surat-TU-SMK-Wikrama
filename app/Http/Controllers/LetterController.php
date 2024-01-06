<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Letter;
use App\Models\LetterType;
use Illuminate\Http\Request;
use Excel;
use App\Exports\DataExport;
use Illuminate\Support\Facades\Auth;


class LetterController extends Controller
{

    public function index(Request $request)
    {
        $search = $request->input('search');
        $query = Letter::with('letterType');

        if (!empty($search)) {
            $query->whereHas('letterType', function ($query) use ($search) {
                $query->where('letter_code', 'like', '%' . $search . '%')
                    ->orWhere('name_type', 'like', '%' . $search . '%');
            });
        }

        $letters = $query->paginate(2);

        return view('dashboard.letter.index', compact('letters'));
    }

    public function create()
    {
        $letters = LetterType::all();
        $users = User::where('role', 'guru')->get();
        return view('dashboard.letter.create', compact('letters', 'users'));
    }

    

    public function store(Request $request)
    {
        $request->validate([
            // ... validasi lainnya ...
            'letter_perihal' => 'required',
            'letter_type_id' => 'required',
            'content' => 'required',
            'recipients' => 'required|array',
            'notulis' => 'required',
        ]);

        $letter = Letter::create([
            'letter_perihal' => $request->letter_perihal,
            'letter_type_id' => $request->letter_type_id,
            'content' => $request->content,
            'recipients' => json_encode($request->recipients),
            'notulis' => $request->notulis,
        ]);

        if (Auth::user()->role === 'guru') {
            $letter->update(['meeting_result' => true]);
        }

        return redirect()->route('letter.index')->with('success', 'Berhasil menambahkan data!');
    }



    public function show($id)
    {
        $letters = Letter::findOrFail($id);
        $users = User::where('role', 'guru')->get();
        $letterType = $letters->letterType; // Assuming 'letterType' is the relationship between Letter and LetterType

        return view('dashboard.letter.detail', compact('letters', 'users', 'letterType'));
    }




    public function edit($id)
    {
        $letter = Letter::findOrFail($id);
        $letters = LetterType::all();
        $users = User::where('role', 'guru')->get();

        return view('dashboard.letter.edit', compact('letter', 'letters', 'users'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            // ... validasi lainnya ...
            'letter_perihal' => 'required',
            'letter_type_id' => 'required',
            'content' => 'required',
            'recipients' => 'required|array',
            'notulis' => 'required',
        ]);

        $letter = Letter::findOrFail($id);

        // Update data surat dengan informasi yang baru
        $letter->update([
            'letter_perihal' => $request->letter_perihal,
            'letter_type_id' => $request->letter_type_id,
            'content' => $request->content,
            'recipients' => json_encode($request->recipients),
            'notulis' => $request->notulis,
        ]);

        return redirect()->route('letter.index')->with('success', 'Berhasil memperbarui data!');
    }


    public function destroy(string $id)
    {
        Letter::where('id', $id)->delete();

        return redirect()->back()->with('deleted', 'Berhasil menghapus data!');
    }

    public function countOutgoingLetters()
    {
        $countSuratKeluar = Letter::count();
        return $countSuratKeluar;
    }

    public function exportExcel()
    {
        $file_name = 'Data_Surat' . '.xlsx';
        return Excel::download(new DataExport, $file_name);
    }



}
