
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat Konsultasi - Ruang Puan</title>
    <style>
        body { font-family:Arial,sans-serif; background:#f7f5ed; color:#263c32; margin:0; padding:25px; }
        .container { max-width:850px; margin:auto; }
        .header,.chat-box,.form-box { background:white; padding:20px; border-radius:13px; margin-bottom:15px; }
        .chat-box { min-height:350px; }
        .message { max-width:75%; padding:12px 15px; border-radius:12px; margin:12px 0; background:#edf0e9; }
        .mine { margin-left:auto; background:#dce9dc; }
        .time { display:block; font-size:11px; color:#718078; margin-top:6px; }
        textarea { width:100%; box-sizing:border-box; padding:12px; border:1px solid #ccd5cc; border-radius:8px; resize:vertical; }
        button { background:#28543d; color:white; border:0; padding:12px 20px; border-radius:8px; cursor:pointer; margin-top:10px; }
        .muted { color:#718078; }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <a href="{{ route('pengguna.riwayat-konsultasi') }}" class="muted">← Kembali ke Riwayat</a>
        <h2>Chat dengan {{ $konsultasi->pemesanan->jadwalKonsultasi->konselor->user->nama ?? 'Konselor' }}</h2>
        <p class="muted">Konsultasi tanggal {{ $konsultasi->tanggal_konsultasi }}</p>
    </div>

    <div class="chat-box">
        @forelse ($konsultasi->pesans as $pesan)
            <div class="message {{ $pesan->pengirim_id == auth()->id() ? 'mine' : '' }}">
                <strong>{{ $pesan->pengirim->nama ?? 'Pengguna' }}</strong>
                <p>{{ $pesan->isi_pesan }}</p>
                <span class="time">{{ $pesan->waktu_kirim }}</span>
            </div>
        @empty
            <p class="muted">Belum ada pesan. Silakan mulai percakapan.</p>
        @endforelse
    </div>

    @if (!in_array($konsultasi->status, ['selesai', 'batal']))
        <div class="form-box">
            <form action="{{ route('pengguna.chat.store', $konsultasi->id) }}" method="POST">
                @csrf
                <textarea name="isi_pesan" rows="3" placeholder="Tulis pesan Anda..." required>{{ old('isi_pesan') }}</textarea>
                @error('isi_pesan')
                    <p style="color:red">{{ $message }}</p>
                @enderror
                <button type="submit">Kirim Pesan</button>
            </form>
        </div>
    @else
        <p class="muted">Konsultasi telah berakhir. Anda hanya dapat membaca percakapan.</p>
    @endif
</div>
</body>
</html>
