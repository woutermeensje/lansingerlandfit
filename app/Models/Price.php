<?php

namespace App\Models;

use App\Support\Site;
use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    protected $fillable = ['title', 'price', 'unit', 'extra', 'features', 'cta', 'interest', 'highlight', 'sort_order'];

    protected function casts(): array
    {
        return ['features' => 'array', 'highlight' => 'boolean', 'sort_order' => 'integer'];
    }

    protected static function booted(): void
    {
        static::saved(fn () => Site::flush());
        static::deleted(fn () => Site::flush());
    }

    /** Zelfde vorm als een pakket in de oude config('site.prices'). */
    public function toContent(): array
    {
        return [
            'title' => $this->title,
            'price' => $this->price,
            'unit' => $this->unit,
            'extra' => $this->extra,
            'features' => $this->features ?? [],
            'cta' => $this->cta,
            'interest' => $this->interest,
            'highlight' => $this->highlight,
        ];
    }
}
