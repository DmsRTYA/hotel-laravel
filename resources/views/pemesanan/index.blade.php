@extends('layouts.app')
@section('title','The Grand Mugarsari')
@section('content')

<section class="hero">
    <p class="hero-eyebrow">✦ Sistem Reservasi Online ✦</p>
    <h1>Selamat Datang di <em>The Grand Mugarsari</em></h1>
    <div class="gold-divider"></div>
    <p class="hero-desc">Lakukan pemesanan kamar dengan mudah, cepat, dan aman. Pengalaman menginap terbaik menanti Anda.</p>
</section>

<main class="container">

    @if(session('sukses'))
        <div class="alert alert-sukses">{{ session('sukses') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-error">{{ session('error') }}</div>
    @endif
    @if($errors->any())
        <div class="error-list">
            <strong>⚠️ Terdapat kesalahan pada formulir:</strong>
            <ul>@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </div>
    @endif

    <div class="stats-bar">
        <div class="stat-item">
            <div class="stat-number">{{ $total_pesan }}</div>
            <div class="stat-label">Total Reservasi</div>
        </div>
        <div class="stat-item">
            <div class="stat-number">{{ $total_checkin }}</div>
            <div class="stat-label">Tamu Check-in</div>
        </div>
        <div class="stat-item">
            <div class="stat-number">{{ $total_booking }}</div>
            <div class="stat-label">Booking</div>
        </div>
        <div class="stat-item">
            <div class="stat-number">Rp {{ number_format($total_revenue,0,',','.') }}</div>
            <div class="stat-label">Total Pendapatan</div>
        </div>
    </div>

    <section id="form-pesan">
        <h2 class="section-title">✦ Formulir Reservasi</h2>
        <p class="section-sub">LENGKAPI DATA BERIKUT UNTUK MELAKUKAN PEMESANAN</p>
        <div class="card">
            <div class="rooms-grid" id="rooms-grid">
                @foreach($hargaKamar as $jenis => $harga)
                <div class="room-card {{ old('jenis_kamar')==$jenis ? 'selected' : '' }}"
                     onclick="pilihKamar(this,'{{ $jenis }}',{{ $harga }})">
                    <div class="room-name">{{ $jenis }}</div>
                    <div class="room-price">Rp {{ number_format($harga,0,',','.') }}/malam</div>
                </div>
                @endforeach
            </div>

            <form action="{{ route('pemesanan.store') }}" method="POST" id="formPemesanan">
                @csrf
                <div class="form-grid">
                    <div class="form-group">
                        <label for="nama_tamu">Nama Lengkap Tamu *</label>
                        <input type="text" id="nama_tamu" name="nama_tamu" value="{{ old('nama_tamu') }}"
                               placeholder="Masukkan nama lengkap"
                               class="{{ $errors->has('nama_tamu') ? 'input-error' : '' }}" required>
                        @error('nama_tamu')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label for="email">Alamat Email *</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}"
                               placeholder="contoh@email.com"
                               class="{{ $errors->has('email') ? 'input-error' : '' }}" required>
                        @error('email')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label for="no_telepon">Nomor Telepon / WA *</label>
                        <input type="text" id="no_telepon" name="no_telepon" value="{{ old('no_telepon') }}"
                               placeholder="+62 8xx-xxxx-xxxx"
                               class="{{ $errors->has('no_telepon') ? 'input-error' : '' }}" required>
                        @error('no_telepon')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label for="no_identitas">No. KTP / Paspor *</label>
                        <input type="text" id="no_identitas" name="no_identitas" value="{{ old('no_identitas') }}"
                               placeholder="Nomor identitas resmi"
                               class="{{ $errors->has('no_identitas') ? 'input-error' : '' }}" required>
                        <span class="input-hint">Diperlukan untuk proses check-in</span>
                        @error('no_identitas')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label for="jenis_kamar">Jenis Kamar *</label>
                        <select id="jenis_kamar" name="jenis_kamar" required onchange="updateHarga()"
                                class="{{ $errors->has('jenis_kamar') ? 'input-error' : '' }}">
                            <option value="">-- Pilih Jenis Kamar --</option>
                            @foreach($hargaKamar as $jenis => $harga)
                            <option value="{{ $jenis }}" data-harga="{{ $harga }}"
                                {{ old('jenis_kamar')==$jenis ? 'selected' : '' }}>
                                {{ $jenis }} — Rp {{ number_format($harga,0,',','.') }}/malam
                            </option>
                            @endforeach
                        </select>
                        @error('jenis_kamar')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label for="jumlah_kamar">Jumlah Kamar *</label>
                        <input type="number" id="jumlah_kamar" name="jumlah_kamar"
                               value="{{ old('jumlah_kamar',1) }}" min="1" max="10" required oninput="updateHarga()">
                        @error('jumlah_kamar')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label for="tanggal_masuk">Tanggal Check-in *</label>
                        <input type="date" id="tanggal_masuk" name="tanggal_masuk"
                               value="{{ old('tanggal_masuk') }}"
                               class="{{ $errors->has('tanggal_masuk') ? 'input-error' : '' }}"
                               required oninput="updateHarga()">
                        @error('tanggal_masuk')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label for="tanggal_keluar">Tanggal Check-out *</label>
                        <input type="date" id="tanggal_keluar" name="tanggal_keluar"
                               value="{{ old('tanggal_keluar') }}"
                               class="{{ $errors->has('tanggal_keluar') ? 'input-error' : '' }}"
                               required oninput="updateHarga()">
                        @error('tanggal_keluar')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label for="jumlah_tamu">Jumlah Tamu *</label>
                        <input type="number" id="jumlah_tamu" name="jumlah_tamu"
                               value="{{ old('jumlah_tamu',1) }}" min="1" max="20" required>
                        @error('jumlah_tamu')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label for="status">Status Pemesanan</label>
                        <select id="status" name="status">
                            @foreach(['Booking','Dikonfirmasi','Check-in','Check-out','Dibatalkan'] as $s)
                            <option value="{{ $s }}" {{ old('status','Booking')==$s ? 'selected' : '' }}>{{ $s }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group full">
                        <label for="permintaan">Permintaan Khusus</label>
                        <textarea id="permintaan" name="permintaan"
                                  placeholder="Misalnya: kamar di lantai tinggi, lantai jauh dari lift, kebutuhan khusus, dll.">{{ old('permintaan') }}</textarea>
                    </div>
                    <div class="form-group full">
                        <div class="price-preview">
                            <div>
                                <div class="price-label">Estimasi Total Biaya</div>
                                <div style="font-size:.78rem;color:var(--text-light);margin-top:3px" id="detail-harga">
                                    Pilih kamar dan tanggal terlebih dahulu</div>
                            </div>
                            <div class="price-amount" id="total-harga">Rp 0</div>
                        </div>
                        <input type="hidden" name="total_harga" id="total_harga_input" value="{{ old('total_harga',0) }}">
                    </div>
                </div>
                <div class="form-actions">
                    <button type="reset" class="btn-cancel" onclick="resetForm()">✕ Reset</button>
                    <button type="submit" class="btn-submit">✦ Konfirmasi Pemesanan</button>
                </div>
            </form>
        </div>
    </section>

    <section id="daftar-pesan" class="section-gap">
        <h2 class="section-title">✦ Data Pemesanan</h2>
        <p class="section-sub">KELOLA SELURUH DATA RESERVASI TAMU</p>
        <div class="card">
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>#</th><th>Nama Tamu</th><th>Kontak</th><th>No. Identitas</th>
                            <th>Kamar</th><th>Check-in</th><th>Check-out</th><th>Tamu</th>
                            <th>Total Harga</th><th>Status</th><th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($pemesanan as $i => $p)
                        <tr>
                            <td>{{ $i+1 }}</td>
                            <td>
                                <strong style="color:var(--cream)">{{ $p->nama_tamu }}</strong>
                                <br><span style="font-size:.75rem;color:var(--text-light)">{{ $p->email }}</span>
                            </td>
                            <td>{{ $p->no_telepon }}</td>
                            <td>{{ $p->no_identitas }}</td>
                            <td>{{ $p->jenis_kamar }}<br>
                                <span style="font-size:.75rem;color:var(--text-light)">{{ $p->jumlah_kamar }} kamar</span>
                            </td>
                            <td>{{ \Carbon\Carbon::parse($p->tanggal_masuk)->isoFormat('D MMM Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($p->tanggal_keluar)->isoFormat('D MMM Y') }}</td>
                            <td>{{ $p->jumlah_tamu }} orang</td>
                            <td style="color:var(--gold);font-weight:700;">
                                Rp {{ number_format($p->total_harga,0,',','.') }}
                            </td>
                            <td>
                                @php
                                $bm=['Booking'=>'badge-booking','Dikonfirmasi'=>'badge-dikonfirmasi',
                                     'Check-in'=>'badge-checkin','Check-out'=>'badge-checkout',
                                     'Dibatalkan'=>'badge-dibatalkan'];
                                @endphp
                                <span class="badge {{ $bm[$p->status] ?? 'badge-booking' }}">{{ $p->status }}</span>
                            </td>
                            <td>
                                <div class="actions">
                                    <a href="{{ route('pemesanan.edit',$p->id) }}" class="btn-edit">✏️ Edit</a>
                                    <button class="btn-hapus"
                                            onclick="konfirmasiHapus({{ $p->id }},'{{ addslashes($p->nama_tamu) }}')">
                                        🗑️ Hapus
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="11">
                                <div class="empty-state">
                                    <div class="icon">🏨</div>
                                    <p>Belum ada data pemesanan.<br>Lakukan reservasi pertama Anda!</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</main>

<div class="modal-overlay" id="modalHapus">
    <div class="modal-box">
        <div class="modal-icon">🗑️</div>
        <div class="modal-title">Hapus Data Pemesanan?</div>
        <div class="modal-desc" id="modal-nama-tamu">Data ini akan dihapus secara permanen.</div>
        <div class="modal-actions">
            <button class="btn-modal-cancel" onclick="tutupModal()">Batal</button>
            <form id="formHapus" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-confirm-delete">Ya, Hapus</button>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
const hargaKamar = @json($hargaKamar);
function pilihKamar(el,jenis,harga){
    document.querySelectorAll('.room-card').forEach(c=>c.classList.remove('selected'));
    el.classList.add('selected');
    document.getElementById('jenis_kamar').value=jenis;
    updateHarga();
}
function updateHarga(){
    const kamar=document.getElementById('jenis_kamar');
    const jumlah=parseInt(document.getElementById('jumlah_kamar').value)||0;
    const masuk=document.getElementById('tanggal_masuk').value;
    const keluar=document.getElementById('tanggal_keluar').value;
    if(!kamar.value||!masuk||!keluar){
        document.getElementById('total-harga').textContent='Rp 0';
        document.getElementById('detail-harga').textContent='Pilih kamar dan tanggal terlebih dahulu';
        document.getElementById('total_harga_input').value=0;
        return;
    }
    const malam=Math.max(0,Math.round((new Date(keluar)-new Date(masuk))/(1000*60*60*24)));
    const harga=hargaKamar[kamar.value]||0;
    const total=harga*jumlah*malam;
    document.querySelectorAll('.room-card').forEach(c=>{
        c.classList.toggle('selected',c.querySelector('.room-name').textContent.trim()===kamar.value);
    });
    document.getElementById('total-harga').textContent='Rp '+total.toLocaleString('id-ID');
    document.getElementById('detail-harga').textContent=kamar.value+' × '+jumlah+' kamar × '+malam+' malam';
    document.getElementById('total_harga_input').value=total;
}
const today=new Date().toISOString().split('T')[0];
document.getElementById('tanggal_masuk').min=today;
document.getElementById('tanggal_keluar').min=today;
document.getElementById('tanggal_masuk').addEventListener('change',function(){
    document.getElementById('tanggal_keluar').min=this.value;
    updateHarga();
});
function resetForm(){
    document.querySelectorAll('.room-card').forEach(c=>c.classList.remove('selected'));
    document.getElementById('total-harga').textContent='Rp 0';
    document.getElementById('detail-harga').textContent='Pilih kamar dan tanggal terlebih dahulu';
    document.getElementById('total_harga_input').value=0;
}
function konfirmasiHapus(id,nama){
    document.getElementById('modal-nama-tamu').textContent=
        'Anda akan menghapus data pemesanan atas nama: "'+nama+'". Tindakan ini tidak dapat dibatalkan.';
    document.getElementById('formHapus').action='/hapus/'+id;
    document.getElementById('modalHapus').classList.add('active');
}
function tutupModal(){document.getElementById('modalHapus').classList.remove('active');}
document.getElementById('modalHapus').addEventListener('click',function(e){if(e.target===this)tutupModal();});
window.addEventListener('load',()=>{if(document.getElementById('jenis_kamar').value)updateHarga();});
</script>
@endpush
