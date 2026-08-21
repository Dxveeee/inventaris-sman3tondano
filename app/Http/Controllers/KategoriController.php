<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index()
    {
        $kategori = Kategori::latest()->get();
        return view('admin.kategori_barang', compact('kategori'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'        => 'required|string|max:100|unique:kategori,nama',
            'kode_prefix' => 'nullable|string|max:5',
            'deskripsi'   => 'nullable|string|max:255',
        ]);

        Kategori::create([
            'nama'        => $request->nama,
            'kode_prefix' => $request->kode_prefix ? strtoupper($request->kode_prefix) : null,
            'deskripsi'   => $request->deskripsi,
        ]);

        return back()->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $kategori = Kategori::findOrFail($id);

        $request->validate([
            'nama'        => 'required|string|max:100|unique:kategori,nama,' . $kategori->id,
            'kode_prefix' => 'nullable|string|max:5',
            'deskripsi'   => 'nullable|string|max:255',
        ]);

        $kategori->update([
            'nama'        => $request->nama,
            'kode_prefix' => $request->kode_prefix ? strtoupper($request->kode_prefix) : null,
            'deskripsi'   => $request->deskripsi,
        ]);

        return back()->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy($id)
    {
        Kategori::findOrFail($id)->delete();
        return back()->with('success', 'Kategori berhasil dihapus.');
    }
}
