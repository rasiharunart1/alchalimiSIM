<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tagihan extends Model
{
    use HasFactory;

    protected $table = 'tagihan';

    protected $fillable = [
        'santri_id',
        'jenis',
        'bulan',
        'jumlah',
        'status',
    ];

    protected $casts = [
        'jumlah' => 'decimal:2',
    ];

    /**
     * Relationship: Tagihan belongs to Santri
     */
    public function santri()
    {
        return $this->belongsTo(Santri::class);
    }

    /**
     * Relationship: Tagihan has many Pembayaran
     */
    public function pembayaran()
    {
        return $this->hasMany(Pembayaran::class, 'tagihan_id');
    }

    /**
     * Scope: Filter tagihan belum lunas
     */
    public function scopeBelumLunas($query)
    {
        return $query->where('status', 'belum_lunas');
    }

    /**
     * Scope: Filter tagihan bulan ini
     */
    public function scopeBulanIni($query)
    {
        return $query->where('bulan', now()->format('Y-m'));
    }
}
