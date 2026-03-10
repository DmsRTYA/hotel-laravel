<?php

namespace App\Http\Controllers;

use App\Models\Pemesanan;
use Illuminate\Http\Request;

class PemesananController extends Controller
{
    private array $hargaKamar = [
        'Standard'     => 350000,
        'Superior'     => 500000,
        'Deluxe'       => 750000,
        'Junior Suite' => 1100000,
        'Suite'        => 1800000,
        'Presidential' => 3500000,
    ];

    public function index()
    {
        $pemesanan     = Pemesanan::orderBy('created_at', 'desc')->get();
        $total_pesan   = Pemesanan::count();
        $total_checkin = Pemesanan::where('status', 'Check-in')->count();
        $total_booking = Pemesanan::where('status', 'Booking')->count();
        $total_revenue = Pemesanan::where('status', '!=', 'Dibatalkan')->sum('total_harga');

        return view('pemesanan.index', compact(
            'pemesanan','total_pesan','total_checkin','total_booking','total_revenue'
        ) + ['hargaKamar' => $this->hargaKamar]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_tamu'      => 'required|string|max:100',
            'email'          => 'required|email|max:100',
            'no_telepon'     => 'required|string|max:20',
            'no_identitas'   => 'required|string|max:30',
            'jenis_kamar'    => 'required|in:'.implode(',', array_keys($this->hargaKamar)),
            'jumlah_kamar'   => 'required|integer|min:1|max:10',
            'tanggal_masuk'  => 'required|date|after_or_equal:today',
            'tanggal_keluar' => 'required|date|after:tanggal_masuk',
            'jumlah_tamu'    => 'required|integer|min:1|max:20',
            'permintaan'     => 'nullable|string',
            'status'         => 'required|in:Booking,Dikonfirmasi,Check-in,Check-out,Dibatalkan',
            'total_harga'    => 'required|numeric|min:0',
        ], [
            'nama_tamu.required'           => 'Nama tamu wajib diisi.',
            'email.email'                  => 'Format email tidak valid.',
            'tanggal_masuk.after_or_equal' => 'Tanggal check-in tidak boleh sebelum hari ini.',
            'tanggal_keluar.after'         => 'Tanggal check-out harus setelah check-in.',
        ]);

        Pemesanan::create($validated);
        return redirect('/')->with('sukses', '✅ Pemesanan berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $pemesanan = Pemesanan::findOrFail($id);
        return view('pemesanan.edit', ['pemesanan' => $pemesanan, 'hargaKamar' => $this->hargaKamar]);
    }

    public function update(Request $request, $id)
    {
        $pemesanan = Pemesanan::findOrFail($id);
        $validated = $request->validate([
            'nama_tamu'      => 'required|string|max:100',
            'email'          => 'required|email|max:100',
            'no_telepon'     => 'required|string|max:20',
            'no_identitas'   => 'required|string|max:30',
            'jenis_kamar'    => 'required|in:'.implode(',', array_keys($this->hargaKamar)),
            'jumlah_kamar'   => 'required|integer|min:1|max:10',
            'tanggal_masuk'  => 'required|date',
            'tanggal_keluar' => 'required|date|after:tanggal_masuk',
            'jumlah_tamu'    => 'required|integer|min:1|max:20',
            'permintaan'     => 'nullable|string',
            'status'         => 'required|in:Booking,Dikonfirmasi,Check-in,Check-out,Dibatalkan',
            'total_harga'    => 'required|numeric|min:0',
        ]);
        $pemesanan->update($validated);
        return redirect('/')->with('sukses', '✅ Data pemesanan berhasil diperbarui!');
    }

    public function destroy($id)
    {
        Pemesanan::findOrFail($id)->delete();
        return redirect('/')->with('sukses', '🗑️ Data pemesanan berhasil dihapus!');
    }
}
