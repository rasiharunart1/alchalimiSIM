<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Santri extends Model
{
    use HasFactory;

    protected $table = 'santri';

    protected $fillable = [
        'wali_id',
        'nis',
        'nama_lengkap',
        'nama_panggilan',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'alamat',
        'sekolah_asal',
        'tanggal_masuk',
        'status',
        'foto',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'tanggal_masuk' => 'date',
    ];

    /**
     * Relationship: Santri belongs to Wali
     */
    public function wali()
    {
        return $this->belongsTo(User::class, 'wali_id');
    }

    /**
     * Relationship: Santri has many Pembayaran
     */
    public function pembayaran()
    {
        return $this->hasMany(Pembayaran::class);
    }

    /**
     * Relationship: Santri has many Tagihan
     */
    public function tagihan()
    {
        return $this->hasMany(Tagihan::class);
    }

    /**
     * Relationship: Santri has many Hafalan
     */
    public function hafalan()
    {
        return $this->hasMany(Hafalan::class);
    }

    /**
     * Accessor: Get umur santri
     */
    public function getUmurAttribute()
    {
        return $this->tanggal_lahir->age;
    }

    /**
     * Accessor: Get progress hafalan (total halaman / 604)
     */
    public function getProgressHafalanAttribute()
    {
        // 1. Hitung jumlah juz yang sudah LULUS * 20 halaman
        $completedJuz = $this->hafalan()
            ->where('status', 'lulus')
            ->distinct('juz')
            ->count('juz');
        
        $completedPages = $completedJuz * 20;

        // 2. Cari progres halaman di juz yang sedang berjalan (belum lulus)
        // Ambil Juz yang sedang aktif dikerjakan (berdasarkan input terakhir)
        $latestInput = $this->hafalan()
            ->where('status', '!=', 'lulus')
            ->latest('tanggal')
            ->latest('id')
            ->first();

        $currentPages = 0;
        if ($latestInput) {
            // Ambil halaman TERTINGGI yang pernah dicapai di juz ini
            // (Agar jika ada setoran ulang/murajaah ke belakang, progres tidak turun)
            $maxPageInJuz = $this->hafalan()
                ->where('juz', $latestInput->juz)
                ->where('status', '!=', 'lulus')
                ->max('halaman');

            $currentPages = $maxPageInJuz ?? 0;
        }

        $totalPages = $completedPages + $currentPages;
        
        // Cap at 604 (30 juz * ~20 pages, standard mushaf pojok is 604)
        if ($totalPages > 604) $totalPages = 604;

        return [
            'total_pages' => $totalPages,
            'percent' => ($totalPages / 604) * 100,
            'label' => round(($totalPages / 604) * 30, 1) // Estimasi capaian Juz (ex: 5.5 Juz)
        ];
    }

    /**
     * Accessor: Get total tunggakan
     */
    public function getTotalTunggakanAttribute()
    {
        return $this->tagihan()
            ->where('status', 'belum_lunas')
            ->sum('jumlah');
    }

    /**
     * Scope: Filter santri aktif
     */
    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif');
    }
}
