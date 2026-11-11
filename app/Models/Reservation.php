<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $fillable = ['lesson_id', 'lesson_name', 'date', 'starts_at', 'ends_at', 'location', 'name', 'email'];

    protected function casts(): array
    {
        return ['date' => 'date'];
    }
}
