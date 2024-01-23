<?php

namespace App\Http\Controllers;

use App\Models\Material;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class MaterialController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('super.admin');
    }

    public function index()
    {
        return response()->view('material', [
            'allMaterial' => Material::where('is_delete', false)->latest()->get()
        ]);
    }

    public function addMaterial(Request $request)
    {
        $request->validate([
            'nama' => ['required'],
            'stok' => ['required'],
        ]);
        if ($request->nama && Material::where('name', $request->nama)->first() !== null)
            throw ValidationException::withMessages([
                'nama' => 'nama material ini sudah ada'
            ]);
        Material::create([
            'name' => $request->nama,
            'stok' => $request->stok,
        ]);
        return back()->with('success', 'Berhasil menambahkan material baru');
    }

    public function updateStokMaterial(Request $request)
    {
        $request->validate([
            'stok' => ['required', 'min:0']
        ]);
        if (!isset($request->id))
            throw ValidationException::withMessages([
                'material' => 'Material tidak ditemukan'
            ]);
        $material = Material::find($request->id);
        if ($material) {
            $material->stok = $request->stok;
            $material->save();
            return back()->with('success', 'Berhasil mengubah stok material ' . $material->name);
        }
    }

    public function deleteMaterial(Request $request)
    {
        $material = Material::find($request->id);
        if ($material == null)
            throw ValidationException::withMessages([
                'material' => 'Material tidak ditemukan'
            ]);
        $material->is_delete = true;
        $material->save();
        return back()->with('success', 'Berhasil menghapus material' . $material->name);
    }
}
