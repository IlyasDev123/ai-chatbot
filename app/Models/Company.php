<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = ['name', 'slug', 'logo'];

    public function events()
    {
        return $this->hasMany(Event::class);
    }
}
