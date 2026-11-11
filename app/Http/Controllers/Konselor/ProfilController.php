<?php

namespace App\Http\Controllers\Konselor;

use App\Http\Controllers\Controller;
use App\Models\Konselor;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;

class ProfilController extends Controller
{
    public const SPESIALISASI = [
        'Kekerasan dalam Rumah Tangga',
        'Kekerasan Seksual',
        'Trauma Psikologis',
        'Kesehatan Mental',
        'Pelecehan di Tempat Kerja',
        'Kekerasan Berbasis Gender Online',
        'Konseling Keluarga',
        'Konseling Remaja',
    ];

    public const DURASI = [30, 45, 60, 90];

    public function edit(Request $request)
    {
        $user = $request->user();
        $konselor = $user->konselor ?? new Konselor();

        return view('konselor.profil', [
            'user' => $user,
            'konselor' => $konselor,
            'spesialisasiList' => self::SPESIALISASI,
            'durasiList' => self::DURASI,
        ]);
    }

    public function update(Request $request, string $bagian)
    {
        $user = $request->user();
        $konselor = $user->konselor;

        $data = match ($bagian) {
            'identitas' => $this->identitas($request),
            'kredensial' => $this->kredensial($request, $konselor),
            'layanan' => $this->layanan($request),
            'rekening' => $this->rekening($request),
            'kode-etik' => $this->kodeEtik($request, $konselor),
        };

        $user->konselor()->updateOrCreate(['user_id' => $user->id], $data);

        return redirect()->route('konselor.profil.edit', ['tab' => $bagian])
            ->with('success', 'Perubahan berhasil disimpan.');
    }

    private function identitas(Request $request): array
    {
        return $request->validate([
            'gelar' => ['nullable', 'string', 'max:100'],
            'bio' => ['nullable', 'string', 'max:1000'],
            'pendidikan' => ['nullable', 'string', 'max:1000'],
            'pengalaman_tahun' => ['nullable', 'integer', 'min:0', 'max:60'],
            'bahasa' => ['nullable', 'string', 'max:150'],
        ], [
            'pengalaman_tahun.integer' => 'Pengalaman harus berupa angka (tahun).',
            'pengalaman_tahun.max' => 'Pengalaman maksimal 60 tahun.',
        ]);
    }

    private function kredensial(Request $request, ?Konselor $konselor): array
    {
        $v = $request->validate([
            'no_str' => ['nullable', 'string', 'max:50'],
            'no_sipp' => ['nullable', 'string', 'max:50'],
            'masa_berlaku_str' => ['nullable', 'date'],
            'masa_berlaku_sipp' => ['nullable', 'date'],
            'dokumen_verifikasi' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:10240'],
            'dokumen_ijazah' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:10240'],
        ], [
            'dokumen_verifikasi.mimes' => 'Dokumen STR/SIPP harus PDF, JPG, atau PNG.',
            'dokumen_verifikasi.max' => 'Dokumen STR/SIPP maksimal 10 MB.',
            'dokumen_ijazah.mimes' => 'Ijazah harus PDF, JPG, atau PNG.',
            'dokumen_ijazah.max' => 'Ijazah maksimal 10 MB.',
        ]);

        $data = Arr::only($v, ['no_str', 'no_sipp', 'masa_berlaku_str', 'masa_berlaku_sipp']);

        // R05: mengubah STR, SIPP, atau dokumen mengembalikan status ke "menunggu"
        $reset = (string) ($v['no_str'] ?? '') !== (string) ($konselor->no_str ?? '')
            || (string) ($v['no_sipp'] ?? '') !== (string) ($konselor->no_sipp ?? '');

        if ($request->hasFile('dokumen_verifikasi')) {
            $data['dokumen_verifikasi'] = $request->file('dokumen_verifikasi')->store('dokumen_konselor', 'public');
            $reset = true;
        }

        if ($request->hasFile('dokumen_ijazah')) {
            $data['dokumen_ijazah'] = $request->file('dokumen_ijazah')->store('dokumen_konselor', 'public');
            $reset = true;
        }

        if ($reset) {
            $data['status_verifikasi'] = 'menunggu';
            $data['alasan_penolakan'] = null;
        }

        return $data;
    }

    private function layanan(Request $request): array
    {
        $v = $request->validate([
            'spesialisasi' => ['nullable', 'array'],
            'spesialisasi.*' => ['string', Rule::in(self::SPESIALISASI)],
            'durasi_sesi' => ['nullable', 'integer', Rule::in(self::DURASI)],
            'tarif' => ['nullable', 'numeric', 'min:0'],
            'kebijakan_pembatalan' => ['nullable', 'string', 'max:1000'],
        ]);

        $spesialisasi = $v['spesialisasi'] ?? [];

        return [
            'spesialisasi' => $spesialisasi,
            'bidang_keahlian' => implode(', ', $spesialisasi),
            'durasi_sesi' => $v['durasi_sesi'] ?? null,
            'tarif' => $v['tarif'] ?? 0,
            'kebijakan_pembatalan' => $v['kebijakan_pembatalan'] ?? null,
        ];
    }

    private function rekening(Request $request): array
    {
        return $request->validate([
            'rekening_bank' => ['nullable', 'string', 'max:50'],
            'rekening_nomor' => ['nullable', 'regex:/^[0-9]{5,30}$/'],
            'rekening_atas_nama' => ['nullable', 'string', 'max:100'],
        ], [
            'rekening_nomor.regex' => 'Nomor rekening hanya boleh angka (5-30 digit).',
        ]);
    }

    private function kodeEtik(Request $request, ?Konselor $konselor): array
    {
        $request->validate([
            'setuju' => ['accepted'],
        ], [
            'setuju.accepted' => 'Anda harus menyetujui kode etik dan kerahasiaan.',
        ]);

        return ['kode_etik_disetujui_at' => $konselor?->kode_etik_disetujui_at ?? now()];
    }
}
