<?php

namespace App\Models;

use App\Support\Site;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Lesson extends Model
{
    protected $fillable = ['training_id', 'day', 'name', 'starts_at', 'ends_at', 'location'];

    protected function casts(): array
    {
        return ['day' => 'integer', 'training_id' => 'integer'];
    }

    protected static function booted(): void
    {
        static::saved(fn () => Site::flush());
        static::deleted(fn () => Site::flush());
    }

    public function training(): BelongsTo
    {
        return $this->belongsTo(Training::class);
    }

    /** Zelfde vorm als een les in de oude config('site.schedule'). */
    public function toContent(): array
    {
        return [
            'id' => (string) $this->id,
            'day' => $this->day,
            'training' => $this->training->slug,
            'name' => $this->name,
            'from' => $this->starts_at,
            'to' => $this->ends_at,
            'location' => $this->location,
        ];
    }
}
