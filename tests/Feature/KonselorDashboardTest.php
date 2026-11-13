<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Konselor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class KonselorDashboardTest extends TestCase
{
    use RefreshDatabase;
    public function test_guest_is_redirected_to_login(): void
    {
        $response = $this->get('/konselor/dashboard');
        $response->assertRedirect('/login');
    }

    public function test_konselor_can_view_beranda(): void
    {
        $user = User::factory()->create([
            'nama' => 'Dewi Lestari, M.Psi.',
            'role' => 'konselor',
            'status' => 'aktif',
            'email_verified_at' => now(),
        ]);

        $konselor = Konselor::create([
            'user_id' => $user->id,
            'status_verifikasi' => 'disetujui',
            'bidang_keahlian' => 'Psikolog Klinis',
            'tarif' => 150000,
        ]);

        $response = $this->actingAs($user)->get('/konselor/dashboard');

        $response->assertStatus(200);
        $response->assertSee('Halo, Bu Dewi');
        $response->assertSee('Terverifikasi');
        $response->assertSee('Sesi hari ini');
        $response->assertSee('Booking menunggu');
        $response->assertSee('Sesi selesai bulan ini');
        $response->assertSee('Total sesi');
        $response->assertSee('Sesi berikutnya');
        $response->assertSee('yudahenry');
        $response->assertSee('Pembayaran dikonfirmasi');
        $response->assertSee('Jadwal hari ini');
        $response->assertSee('Performa kamu');
        $response->assertSee('Sesi per bulan');
        $response->assertSee('Hari tersibuk');
        $response->assertSee('Slot terisi');
        $response->assertSee('bungapagi');
        $response->assertSee('langitcerah');
        $response->assertSee('langkahkecil');
    }

    public function test_konselor_can_confirm_and_reject_booking(): void
    {
        $user = User::factory()->create([
            'nama' => 'Dewi Lestari, M.Psi.',
            'role' => 'konselor',
            'status' => 'aktif',
            'email_verified_at' => now(),
        ]);

        $response = $this->actingAs($user)->post('/konselor/booking/1/konfirmasi');
        $response->assertRedirect();
        $response->assertSessionHas('success');

        $responseReject = $this->actingAs($user)->post('/konselor/booking/1/tolak');
        $responseReject->assertRedirect();
        $responseReject->assertSessionHas('success');
    }

    public function test_konselor_can_send_chat_message(): void
    {
        $user = User::factory()->create([
            'nama' => 'Dewi Lestari, M.Psi.',
            'role' => 'konselor',
            'status' => 'aktif',
            'email_verified_at' => now(),
        ]);

        $response = $this->actingAs($user)->postJson('/konselor/chat/kirim', [
            'pesan' => 'Halo, ini pesan pengujian.',
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'status' => 'success',
            'pesan' => 'Halo, ini pesan pengujian.',
        ]);
    }
}
