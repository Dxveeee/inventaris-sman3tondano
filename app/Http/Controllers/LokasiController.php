<?php

namespace App\Http\Controllers;

use App\Models\Lokasi;
use Illuminate\Http\Request;

class LokasiController extends Controller
{
    public function index()
    {
        $lokasi = Lokasi::all();
        return view('admin.lokasi_penyimpanan', compact('lokasi'));
    }

    public function create()
    {
        // Tidak diperlukan karena menggunakan modal
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);

        Lokasi::create($request->all());

        return redirect()->route('admin.lokasi.index')->with('success', 'Lokasi penyimpanan berhasil ditambahkan.');
    }

    public function show(Lokasi $lokasi)
    {
        // Tidak diperlukan
    }

    public function edit(Lokasi $lokasi)
    {
        // Tidak diperlukan karena menggunakan modal
    }

    public function update(Request $request, Lokasi $lokasi)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);

        $lokasi->update($request->all());

        return redirect()->route('admin.lokasi.index')->with('success', 'Lokasi penyimpanan berhasil diperbarui.');
    }

    public function destroy(Lokasi $lokasi)
    {
        $lokasi->delete();

        return redirect()->route('admin.lokasi.index')->with('success', 'Lokasi penyimpanan berhasil dihapus.');
    }
}
