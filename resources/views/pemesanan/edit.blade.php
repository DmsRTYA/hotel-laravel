@extends('layouts.app')
@section('title','Edit Pemesanan — The Grand Mugarsari')
@section('content')
<main class="container" style="max-width:900px">
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:28px">
        <div>
            <h1 class="section-title" style="margin-bottom:4px">✦ Edit Data Pemesanan</h1>
            <p class="section-sub" style="margin-bottom:0">Perbarui informasi reservasi tamu</p>
        </div>
        <a href="{{ url('/') }}" class="btn-cancel">← Kembali</a>
    </div>
    <div style="margin-bottom:20px">
        <span style="display:inline-block;background:rgba(201,168,76,.12);border:1px solid rgba(201,168,76,.3);color:var(--gold);padding:5px 16px;border-radius:20px;font-size:.82rem;font-weight:700">
            ID Reservasi: #{{ str_pad($pemesanan->id,4,'0',STR_PAD_LEFT) }}
        </span>
        <span style="margin-left:10px;font-size:.78rem;color:var(--text-light)">
            Dibuat: {{ \Carbon\Carbon::parse($pemesanan->created_at)->isoFormat('D MMM Y, HH:mm') }}
        </span>
    </div>
    @if($errors->any())
        <div class="error-list">
            <strong>⚠️ Terdapat kesalahan:</strong>
            <ul>@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </div>
    @endif
    <div class="card">
        <form action="{{ route('pemesanan.update',$pemesanan->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div style="font-size:.68rem;letter-spacing:3px;text-transform:uppercase;color:var(--gold);border-bottom:1px solid rgba(201,168,76,.2);padding-bottom:10px;margin-bottom:20px">Identitas Tamu</div>
            <div class="form-grid">
                <div class="form-group">
                    <label>Nama Lengkap *</label>
                    <input type="text" name="nama_tamu" value="{{ old('nama_tamu',$pemesanan->nama_tamu) }}"
                           class="{{ $errors->has('nama_tamu') ? 'input-error' : '' }}" required>
                    @error('nama_tamu')<span class="field-error">{{ $message }}</span>@enderror
                </div>
                <div class="form-group">
                    <label>Alamat Email *</label>
                    <input type="email" name="email" value="{{ old('email',$pemesanan->email) }}"
                           class="{{ $errors->has('email') ? 'input-error' : '' }}" required>
                    @error('email')<span class="field-error">{{ $message }}</span>@enderror
                </div>
                <div class="form-group">
                    <label>Nomor Telepon *</label>
                    <input type="text" name="no_telepon" value="{{ old('no_telepon',$pemesanan->no_telepon) }}"
                           class="{{ $errors->has('no_telepon') ? 'input-error' : '' }}" required>
                    @error('no_telepon')<span class="field-error">{{ $message }}</span>@enderror
                </div>
                <div class="form-group">
                    <label>No. KTP / Paspor *</label>
                    <input type="text" name="no_identitas" value="{{ old('no_identitas',$pemesanan->no_identitas) }}"
                           class="{{ $errors->has('no_identitas') ? 'input-error' : '' }}" required>
                    <span class="input-hint">Nomor identitas resmi tamu</span>
                    @error('no_identitas')<span class="field-error">{{ $message }}</span>@enderror
                </div>
            </div>
            <div style="font-size:.68rem;letter-spacing:3px;text-transform:uppercase;color:var(--gold);border-bottom:1px solid rgba(201,168,76,.2);padding-bottom:10px;margin-bottom:20px;margin-top:28px">Detail Kamar &amp; Menginap</div>
            <div class="form-grid">
                <div class="form-group">
                    <label>Jenis Kamar *</label>
                    <select id="jenis_kamar" name="jenis_kamar" required onchange="updateHarga()">
                        @foreach($hargaKamar as $jenis => $harga)
                        <option value="{{ $jenis }}" data-harga="{{ $harga }}"
                            {{ old('jenis_kamar',$pemesanan->jenis_kamar)==$jenis ? 'selected' : '' }}>
                            {{ $jenis }} — Rp {{ number_format($harga,0,',','.') }}/malam
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Jumlah Kamar *</label>
                    <input type="number" id="jumlah_kamar" name="jumlah_kamar"
                           value="{{ old('jumlah_kamar',$pemesanan->jumlah_kamar) }}"
                           min="1" max="10" required oninput="updateHarga()">
                </div>
                <div class="form-group">
                    <label>Tanggal Check-in *</label>
                    <input type="date" id="tanggal_masuk" name="tanggal_masuk"
                           value="{{ old('tanggal_masuk',$pemesanan->tanggal_masuk) }}" required oninput="updateHarga()">
                    @error('tanggal_masuk')<span class="field-error">{{ $message }}</span>@enderror
                </div>
                <div class="form-group">
                    <label>Tanggal Check-out *</label>
                    <input type="date" id="tanggal_keluar" name="tanggal_keluar"
                           value="{{ old('tanggal_keluar',$pemesanan->tanggal_keluar) }}" required oninput="updateHarga()">
                    @error('tanggal_keluar')<span class="field-error">{{ $message }}</span>@enderror
                </div>
                <div class="form-group">
                    <label>Jumlah Tamu *</label>
                    <input type="number" name="jumlah_tamu" value="{{ old('jumlah_tamu',$pemesanan->jumlah_tamu) }}"
                           min="1" max="20" required>
                </div>
                <div class="form-group">
                    <label>Status Pemesanan</label>
                    <select name="status">
                        @foreach(['Booking','Dikonfirmasi','Check-in','Check-out','Dibatalkan'] as $s)
                        <option value="{{ $s }}" {{ old('status',$pemesanan->status)==$s ? 'selected' : '' }}>{{ $s }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group full">
                    <label>Permintaan Khusus</label>
                    <textarea name="permintaan" placeholder="Permintaan atau catatan khusus...">{{ old('permintaan',$pemesanan->permintaan) }}</textarea>
                </div>
                <div class="form-group full">
                    <div class="price-preview">
                        <div>
                            <div class="price-label">Estimasi Total Biaya</div>
                            <div style="font-size:.78rem;color:var(--text-light);margin-top:3px" id="detail-harga">Memuat...</div>
                        </div>
                        <div class="price-amount" id="total-harga">Rp 0</div>
                    </div>
                    <input type="hidden" name="total_harga" id="total_harga_input"
                           value="{{ old('total_harga',$pemesanan->total_harga) }}">
                </div>
            </div>
            <div class="form-actions">
                <a href="{{ url('/') }}" class="btn-cancel">✕ Batal</a>
                <button type="submit" class="btn-submit">✦ Simpan Perubahan</button>
            </div>
        </form>
    </div>
</main>
@endsection
@push('scripts')
<script>
const hargaKamar = @json($hargaKamar);
function updateHarga(){
    const kamar=document.getElementById('jenis_kamar');
    const jumlah=parseInt(document.getElementById('jumlah_kamar').value)||0;
    const masuk=document.getElementById('tanggal_masuk').value;
    const keluar=document.getElementById('tanggal_keluar').value;
    if(!kamar.value||!masuk||!keluar)return;
    const malam=Math.max(0,Math.round((new Date(keluar)-new Date(masuk))/(1000*60*60*24)));
    const total=(hargaKamar[kamar.value]||0)*jumlah*malam;
    document.getElementById('total-harga').textContent='Rp '+total.toLocaleString('id-ID');
    document.getElementById('detail-harga').textContent=kamar.value+' × '+jumlah+' kamar × '+malam+' malam';
    document.getElementById('total_harga_input').value=total;
}
window.addEventListener('load',updateHarga);
</script>
@endpush
