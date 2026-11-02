<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLaporanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->role === 'pengguna';
    }

    public function rules(): array
    {
        return [
            'jenis_kasus' => [
                'required',
                'string',
                'in:kekerasan_fisik,kekerasan_psikis,kekerasan_seksual,kdrt,kekerasan_online,lainnya',
            ],
            'kronologi' => [
                'required',
                'string',
                'min:5',
            ],
            'tanggal_kejadian' => [
                'required',
                'date',
            ],
            'waktu_kejadian' => [
                'nullable',
                'string',
                'max:50',
            ],
            'lokasi_kejadian' => [
                'required',
                'string',
                'max:255',
            ],
            'anonim' => [
                'nullable',
            ],
            'bukti' => [
                'nullable',
                'array',
            ],
            'bukti.*' => [
                'nullable',
                'file',
                'mimes:jpg,jpeg,png,pdf,mp4,mov,doc,docx',
                'max:10240',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'jenis_kasus.required' => 'Pilih kategori kasus yang paling sesuai.',
            'jenis_kasus.in' => 'Kategori kasus yang dipilih tidak valid.',
            'kronologi.required' => 'Ceritakan kronologi kejadian yang kamu alami.',
            'kronologi.min' => 'Ceritakan kronologi kejadian lebih jelas.',
            'tanggal_kejadian.required' => 'Tanggal kejadian wajib diisi.',
            'tanggal_kejadian.date' => 'Format tanggal kejadian tidak valid.',
            'lokasi_kejadian.required' => 'Lokasi kejadian wajib diisi.',
            'bukti.*.mimes' => 'Format berkas bukti harus berupa gambar (jpg, png), PDF, dokumen, atau rekaman video/audio.',
            'bukti.*.max' => 'Ukuran berkas bukti maksimal 10MB per berkas.',
        ];
    }
}
