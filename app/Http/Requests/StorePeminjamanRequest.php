<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Barang;

class StorePeminjamanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'nama_barang'             => ['required', 'string'],
            'id_lokasi'               => ['required', 'exists:lokasi,id'],
            'jumlah_pinjam'           => ['required', 'integer', 'min:1'],
            'tanggal_kembali_rencana' => ['required', 'date', 'after:today'],
            'keterangan'              => ['nullable', 'string', 'max:500'],
        ];
    }

    public function messages(): array
    {
        return [
            'nama_barang.required'             => 'Barang harus dipilih.',
            'id_lokasi.required'               => 'Lokasi harus dipilih.',
            'jumlah_pinjam.required'           => 'Jumlah pinjam harus diisi.',
            'jumlah_pinjam.min'                => 'Jumlah pinjam minimal 1.',
            'tanggal_kembali_rencana.required' => 'Tanggal rencana kembali harus diisi.',
            'tanggal_kembali_rencana.after'    => 'Tanggal rencana kembali harus setelah hari ini.',
        ];
    }
}
