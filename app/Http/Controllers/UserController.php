<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Excel;
use App\Exports\OrdersExport;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller
{
    // Bagian Staff

    public function indexSt(Request $request)
    {
        $search = $request->input('search');
        $users = User::where('role', 'staff')
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%')
                        ->orWhere('email', 'like', '%' . $search . '%');
                });
            })
            ->simplePaginate(1);
        return view('dashboard.staff.index', compact('users'));
    }


    public function createSt()
    {
        return view('dashboard.staff.create');
    }

    public function storeSt(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3',
            'email' => 'required|email:dns'
        ]);

        // Generate password from the first 3 characters of email and name
        $password = substr($request->email, 0, 3) . substr($request->name, 0, 3);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($password) // Encrypt the password
        ]);

        return redirect()->route('users.indexSt')->with('success', 'Berhasil menambahkan data!');
    }

    public function editSt(string $id)
    {
        $users = User::find($id);
        return view('dashboard.staff.edit', compact('users'));
    }

    public function updateSt(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|min:3',
            'email' => 'required|email:dns',
            'password' => ''
        ]);


        $userData = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        if ($request->filled('password')) {
            // Jika ya, hash password baru
            $hashedPassword = Hash::make($request->password);
            $userData['password'] = $hashedPassword;
        }

        User::where('id', $id)->update($userData);

        return redirect()->route('users.indexSt')->with('success', 'Berhasil mengubah data!');
    }

    public function destroySt(string $id)
    {
        User::where('id', $id)->delete();

        return redirect()->back()->with('deleted', 'Berhasil menghapus data!');
    }


    // Bagian Guru

    public function indexGr(Request $request)
    {

        $search = $request->input('search');
        $users = User::where('role', 'guru')
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%')
                        ->orWhere('email', 'like', '%' . $search . '%');
                });
            })
            ->simplePaginate(1);
        return view('dashboard.guru.index', compact('users'));
    }

    public function createGr()
    {
        return view('dashboard.guru.create');
    }

    public function storeGr(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3',
            'email' => 'required|email:dns'
        ]);

        // Generate password from the first 3 characters of email and name
        $password = substr($request->email, 0, 3) . substr($request->name, 0, 3);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($password),
            'role' => 'guru' // Encrypt the password
        ]);

        return redirect()->route('users.indexGr')->with('success', 'Berhasil menambahkan data!');
    }

    public function editGr(string $id)
    {
        $users = User::find($id);
        return view('dashboard.guru.edit', compact('users'));
    }

    public function updateGr(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|min:3',
            'email' => 'required|email:dns',
            'password' => 'required'
        ]);


        $userData = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        if ($request->filled('password')) {
            // Jika ya, hash password baru
            $hashedPassword = Hash::make($request->password);
            $userData['password'] = $hashedPassword;
        }

        User::where('id', $id)->update($userData);

        return redirect()->route('users.indexGr')->with('success', 'Berhasil mengubah data!');
    }

    public function destroyGr(string $id)
    {
        User::where('id', $id)->delete();

        return redirect()->back()->with('deleted', 'Berhasil menghapus data!');
    }

    public function countStaff()
    {
        $countStaff = User::where('role', 'staff')->count();
        return $countStaff;
    }

    public function countGuru()
    {
        $countGuru = User::where('role', 'guru')->count();
        return $countGuru;
    }

    public function exportExcel()
    {
        $file_name = 'Data_Klasifikasi_Surat' . '.xlsx';
        return Excel::download(new OrdersExport, $file_name);
    }

    public function loginAuth(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $user = $request->only(['email', 'password']);
        if (Auth::attempt($user)) {
            return redirect()->route('index');
        } else {
            return redirect()->back()->with('failed', 'Proses login gagal, silahkan coba kembali dengan data yang benar!');
        }
    }


    public function logout()
    {
        Auth::logout();
        return redirect()->route('login')->with('logout', 'Anda telah logout!');
    }
}
