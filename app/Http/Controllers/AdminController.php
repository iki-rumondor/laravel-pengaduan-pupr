<?php

namespace App\Http\Controllers;

use App\Models\Koarmat;
use App\Models\User;
use App\Models\Wilayah;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('super.admin');
    }

    public function index()
    {
        $allKoarmat = [];
        foreach (Koarmat::all() as $koarmat) {
            $allWilayahInKoarmat = new Collection();
            foreach (Wilayah::select('kecamatan')->where('koarmat_id', $koarmat->id)->distinct()->get() as $wilayah) {
                $allWilayahInKoarmat->push($wilayah);
            }
            $allKoarmat[$koarmat->name] = $allWilayahInKoarmat;
        }
        return response()->view('daftar-admin', [
            'users' => User::where('id', '!=', auth()->user()->id)->get(),
            'allKoarmat' => $allKoarmat
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'koarmat' => ['required'],
            'nama' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'password' => ['required', Password::min(8)->numbers()->symbols()],
            'konfirmasi_password' => ['required', 'same:password']
        ]);
        $koarmat = Koarmat::where('name', $request->koarmat)->first();
        if ($koarmat == null)
            throw ValidationException::withMessages([
                'koarmat' => 'Koarmat tidak ditemukan'
            ]);
        $validatedData['koarmat_id'] = $koarmat->id;
        $validatedData['name'] = $validatedData['nama'];
        $validatedData['password'] = bcrypt($validatedData['password']);
        try {
            User::create($validatedData);
        } catch (Exception $e) {
            return back()->with('message', $e->getMessage());
        }
        return back()->with('success', 'Berhasil menyimpan admin baru');
    }

    public function delete($id)
    {
        User::find($id)->delete();
        return back()->with('success', 'Berhasil menghapus admin');
    }
}
