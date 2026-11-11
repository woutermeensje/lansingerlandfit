<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactRequest extends Model
{
    protected $fillable = ['first_name', 'last_name', 'email', 'phone', 'interest', 'message', 'source'];

    public function fullName(): string
    {
        return trim($this->first_name.' '.$this->last_name);
    }
}
