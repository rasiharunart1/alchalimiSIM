<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    use HasFactory;

    protected $table = 'pembayaran';

    protected $fillable = [
        'santri_id',
        'tagihan_id',
        'jenis',
        'keterangan',
        'jumlah',
        'tanggal_bayar',
        'metode',
        'bukti_transfer',
        'status',
        'recorded_by',
    ];

    protected $casts = [
        'jumlah' => 'decimal:2',
        'tanggal_bayar' => 'date',
    ];

    /**
     * Relationship: Pembayaran belongs to Santri
     */
    public function santri()
    {
        return $this->belongsTo(Santri::class);
    }

    /**
     * Relationship: Pembayaran belongs to Tagihan
     */
    public function tagihan()
    {
        return $this->belongsTo(Tagihan::class);
    }

    /**
     * Relationship: Pembayaran recorded by User
     */
    public function recordedBy()
    {
        return $this->belongsTo(User::class, 'recorded_by');
    }

    /**
     * Scope: Filter pembayaran bulan ini
     */
    public function scopeBulanIni($query)
    {
        return $query->whereMonth('tanggal_bayar', now()->month)
                    ->whereYear('tanggal_bayar', now()->year);
    }

    /**
     * Scope: Filter by jenis pembayaran
     */
    public function scopeJenis($query, $jenis)
    {
        return $query->where('jenis', $jenis);
    }
    /**
     * Scope: Filter by verified status
     */
    public function scopeKonfirmasi($query)
    {
        return $query->where('status', 'konfirmasi');
    }
}
