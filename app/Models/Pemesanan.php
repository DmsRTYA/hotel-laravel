<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pemesanan extends Model
{
    protected $table   = 'pemesanan';
    protected $guarded = [];

    protected $casts = [
        'tanggal_masuk'  => 'date',
        'tanggal_keluar' => 'date',
        'total_harga'    => 'decimal:2',
        'jumlah_kamar'   => 'integer',
        'jumlah_tamu'    => 'integer',
    ];
}
