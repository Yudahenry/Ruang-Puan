<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Laporan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PelaporanBuatTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_to_login_when_accessing_buat_laporan(): void
    {
        $response = $this->get('/pelaporan/buat');
        $response->assertRedirect('/login');
    }

    public function test_pengguna_can_view_buat_laporan_page(): void
    {
        $user = User::factory()->create([
            'nama' => 'Nadia Amanda',
            'role' => 'pengguna',
        ]);

        $response = $this->actingAs($user)->get('/pelaporan/buat');

        $response->assertStatus(200);
        $response->assertSee('Buat laporan');
        $response->assertSee('01');
        $response->assertSee('Bagaimana kamu ingin melapor?');
        $response->assertSee('02');
        $response->assertSee('Ceritakan kejadian yang kamu alami');
        $response->assertSee('03');
        $response->assertSee('Tambahkan bukti, jika ada');
        $response->assertSee('Tidak harus bercerita dengan sempurna');
        $response->assertSee('Tentang pilihan anonim');
        $response->assertSee('Pantau langkahmu');
    }

    public function test_pengguna_can_submit_laporan_successfully(): void
    {
        Storage::fake('public');

        $user = User::factory()->create([
            'nama' => 'Nadia Amanda',
            'role' => 'pengguna',
        ]);

        $fakeFile = UploadedFile::fake()->create('bukti.png', 500, 'image/png');

        $payload = [
            'anonim' => '1',
            'jenis_kasus' => 'kekerasan_fisik',
            'kronologi' => 'Kronologi lengkap peristiwa yang terjadi pada waktu tersebut.',
            'tanggal_kejadian' => '2026-11-01',
            'waktu_kejadian' => '14:00',
            'lokasi_kejadian' => 'Surabaya',
            'bukti' => [$fakeFile],
        ];

        $response = $this->actingAs($user)->post('/pelaporan', $payload);

        $this->assertDatabaseHas('laporans', [
            'user_id' => $user->id,
            'jenis_kasus' => 'kekerasan_fisik',
            'lokasi_kejadian' => 'Surabaya',
            'anonim' => 1,
        ]);

        $laporan = Laporan::where('user_id', $user->id)->first();
        $this->assertNotNull($laporan);
        $this->assertStringStartsWith('RP-', $laporan->kode_pelacakan);

        $response->assertRedirect(route('pelaporan.lacak', $laporan->kode_pelacakan));
        $response->assertSessionHas('success');

        // Test accessing lacak shows code
        $lacakResponse = $this->actingAs($user)->get(route('pelaporan.lacak', $laporan->kode_pelacakan));
        $lacakResponse->assertStatus(200);
        $lacakResponse->assertSee($laporan->kode_pelacakan);
    }

    public function test_submission_fails_when_required_fields_missing(): void
    {
        $user = User::factory()->create([
            'nama' => 'Nadia Amanda',
            'role' => 'pengguna',
        ]);

        $response = $this->actingAs($user)->post('/pelaporan', []);

        $response->assertSessionHasErrors(['jenis_kasus', 'kronologi', 'tanggal_kejadian', 'lokasi_kejadian']);
    }
}
