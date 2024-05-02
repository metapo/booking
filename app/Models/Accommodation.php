<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Accommodation extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        //todo
    ];

    public function calendars(): HasMany
    {
        return $this->hasMany(Calendar::class);
    }

    //todo methods: activate and deactivate
}
