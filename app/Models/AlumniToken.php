<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlumniToken extends Model
{
    use HasFactory;

    protected $fillable = [
        'token',
        'is_used',
        'used_by',
        'expires_at',
    ];

    protected $casts = [
        'is_used' => 'boolean',
        'expires_at' => 'datetime',
    ];

    /**
     * Scope for valid/usable tokens
     */
    public function scopeValid($query)
    {
        return $query->where('is_used', false)
                     ->where(function($q) {
                         $q->whereNull('expires_at')
                           ->orWhere('expires_at', '>', now());
                     });
    }

    /**
     * Relationship: Token used by User
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'used_by');
    }
}
