<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hafalan extends Model
{
    use HasFactory;

    protected $table = 'hafalan';

    protected $fillable = [
        'santri_id',
        'juz',
        'surah',
        'ayat_mulai',
        'ayat_selesai',
        'status',
        'nilai',
        'catatan',
        'tanggal',
        'ustadz_id',
        'halaman',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'nilai' => 'integer',
    ];

    /**
     * Relationship: Hafalan belongs to Santri
     */
    public function santri()
    {
        return $this->belongsTo(Santri::class);
    }

    /**
     * Relationship: Hafalan belongs to Ustadz
     */
    public function ustadz()
    {
        return $this->belongsTo(User::class, 'ustadz_id');
    }

    /**
     * Scope: Filter hafalan lulus
     */
    public function scopeLulus($query)
    {
        return $query->where('status', 'lulus');
    }

    /**
     * Scope: Filter by santri
     */
    public function scopeBySantri($query, $santriId)
    {
        return $query->where('santri_id', $santriId);
    }
}
