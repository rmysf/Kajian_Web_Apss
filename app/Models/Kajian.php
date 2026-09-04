<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

/**
 * Representasi data utama kajian.
 */
class Kajian extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'organizer_id',
        'mosque_id',
        'speaker_id',
        'category_id',
        'title',
        'slug',
        'description',
        'poster',
        'start_at',
        'end_at',
        'address',
        'latitude',
        'longitude',
        'audience',
        'is_family_friendly',
        'is_free',
        'price',
        'quota',
        'status',
        'is_verified',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'start_at' => 'datetime',
        'end_at' => 'datetime',
        'is_family_friendly' => 'boolean',
        'is_free' => 'boolean',
        'is_verified' => 'boolean',
        'latitude' => 'decimal:7',
        'longitude' => 'decimal:7',
    ];

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * The "booted" method of the model.
     */
    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (Kajian $model) {
            if (empty($model->uuid)) {
                $model->uuid = (string) Str::uuid();
            }

            if (empty($model->slug)) {
                $baseSlug = Str::slug($model->title);
                $slug = $baseSlug;
                
                // Tambahkan random string jika slug sudah ada
                while (self::where('slug', $slug)->exists()) {
                    $slug = $baseSlug . '-' . Str::random(5);
                }
                
                $model->slug = $slug;
            }
        });
    }

    /**
     * Relasi ke organizer yang menyelenggarakan kajian ini.
     */
    public function organizer(): BelongsTo
    {
        return $this->belongsTo(Organizer::class);
    }

    /**
     * Relasi ke masjid tempat diselenggarakannya kajian ini.
     */
    public function mosque(): BelongsTo
    {
        return $this->belongsTo(Mosque::class);
    }

    /**
     * Relasi ke pemateri yang mengisi kajian ini.
     */
    public function speaker(): BelongsTo
    {
        return $this->belongsTo(Speaker::class);
    }

    /**
     * Relasi ke kategori/tema kajian.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Relasi ke jamaah yang terdaftar untuk hadir di kajian ini.
     */
    public function attendees(): HasMany
    {
        return $this->hasMany(KajianAttendee::class);
    }

    /**
     * Relasi ke daftar favorit untuk mengetahui user mana saja yang memfavoritkan kajian ini.
     */
    public function favoritedBy(): HasMany
    {
        return $this->hasMany(Favorite::class);
    }

    /**
     * Scope a query to only include nearby and active kajian.
     */
    public function scopeNearby($query, $lat, $lng, $radius = 5)
    {
        $query->where('status', 'published')
              ->where(function($q) {
                  $q->where('start_at', '>=', now())
                    ->orWhere(function($subQ) {
                        $subQ->where('start_at', '<=', now())
                             ->where('end_at', '>=', now());
                    });
              });

        if ($lat !== null && $lng !== null) {
            $haversine = "(6371 * acos(cos(radians($lat)) * cos(radians(latitude)) * cos(radians(longitude) - radians($lng)) + sin(radians($lat)) * sin(radians(latitude))))";
            $query->select('*')
                  ->selectRaw("{$haversine} AS distance")
                  ->whereRaw("{$haversine} <= ?", [$radius])
                  ->orderBy('distance', 'ASC');
        } else {
            $query->orderBy('start_at', 'ASC');
        }

        return $query;
    }

    /**
     * Get the status label attribute.
     */
    public function getStatusLabelAttribute(): string
    {
        if ($this->status === 'cancelled') {
            return 'Dibatalkan';
        }
        
        if ($this->status === 'rejected') {
            return 'Ditolak';
        }

        $now = now();

        if ($this->end_at && $now > $this->end_at) {
            return 'Selesai';
        }

        if ($this->start_at && $this->end_at && $now >= $this->start_at && $now <= $this->end_at) {
            return 'Sedang Berlangsung';
        }

        if ($this->start_at && $now < $this->start_at) {
            $diffInMinutes = (int) $now->diffInMinutes($this->start_at);
            if ($diffInMinutes < 60) {
                return "Mulai {$diffInMinutes} menit lagi";
            }
            return "Akan Datang";
        }

        return 'Tidak Diketahui';
    }
}
