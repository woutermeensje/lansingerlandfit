<?php

namespace App\Models;

use App\Support\Site;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Training extends Model
{
    protected $fillable = ['slug', 'title', 'image', 'card_image', 'short', 'intro', 'body', 'benefits', 'interest', 'seo_title', 'seo_description', 'sort_order'];

    protected function casts(): array
    {
        return ['body' => 'array', 'benefits' => 'array', 'sort_order' => 'integer'];
    }

    protected static function booted(): void
    {
        static::saved(fn () => Site::flush());
        static::deleted(fn () => Site::flush());
    }

    public function lessons(): HasMany
    {
        return $this->hasMany(Lesson::class);
    }

    /** Zelfde vorm als de oude config('site.trainings.<slug>'). */
    public function toContent(): array
    {
        return [
            'title' => $this->title,
            'image' => $this->image,
            'card_image' => $this->card_image,
            'short' => $this->short,
            'intro' => $this->intro,
            'body' => $this->body ?? [],
            'benefits' => $this->benefits ?? [],
            'interest' => $this->interest ?: $this->title,
            'seo_title' => $this->seo_title,
            'seo_description' => $this->seo_description,
            'updated' => $this->updated_at?->toDateString(),
        ];
    }
}
