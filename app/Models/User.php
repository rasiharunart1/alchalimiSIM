<?php
namespace App\Models;
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'role',
        'address',
        'password',
        'last_seen',
        'photo', // Explicitly add photo as well if missing
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'last_seen' => 'datetime',
        ];
    }

    /**
     * Relationship: User (Wali) has many Santri
     */
    public function santri()
    {
        return $this->hasMany(\App\Models\Santri::class, 'wali_id');
    }

    /**
     * Check if user is admin
     */
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    /**
     * Check if user is wali santri
     */
    public function isWali()
    {
        return $this->role === 'wali_santri';
    }

    /**
     * Check if user is ustadz
     */
    public function isUstadz()
    {
        return $this->role === 'ustadz';
    }

    /**
     * Check if user is pengurus
     */
    public function isPengurus()
    {
        return $this->role === 'pengurus';
    }

    /**
     * Check if user is alumni
     */
    public function isAlumni()
    {
        return $this->role === 'alumni';
    }

    /**
     * Relationship: User (Ustadz) has many Hafalan input
     */
    public function hafalanInput()
    {
        return $this->hasMany(\App\Models\Hafalan::class, 'ustadz_id');
    }

    /**
     * Check if user is online (active in last 5 minutes)
     */
    public function isOnline()
    {
        return $this->last_seen && $this->last_seen->diffInMinutes(now()) < 5;
    }

    /**
     * Get the user's photo URL
     */
    public function getPhotoUrlAttribute()
    {
        if (!$this->photo) {
            return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&background=009b77&color=fff';
        }
        
        // Jika photo sudah lengkap dengan folder
        if (str_contains($this->photo, 'profile-photos/')) {
            return asset('storage/' . $this->photo);
        }
        
        // Jika photo hanya nama file
        return asset('storage/profile-photos/' . $this->photo);
    }
}