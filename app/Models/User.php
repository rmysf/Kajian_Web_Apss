<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Representasi pengguna dalam sistem, meliputi jamaah, organizer, dan admin.
 */
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'google_id',
        'role',
        'phone',
        'photo',
        'latitude',
        'longitude',
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
            'latitude' => 'decimal:7',
            'longitude' => 'decimal:7',
        ];
    }

    /**
     * Relasi ke profil organizer jika user ini adalah seorang organizer.
     */
    public function organizer(): HasOne
    {
        return $this->hasOne(Organizer::class);
    }

    /**
     * Relasi ke daftar kehadiran user pada berbagai kajian.
     */
    public function attendances(): HasMany
    {
        return $this->hasMany(KajianAttendee::class);
    }

    /**
     * Relasi ke daftar kajian yang difavoritkan oleh user.
     */
    public function favorites(): HasMany
    {
        return $this->hasMany(Favorite::class);
    }
}
