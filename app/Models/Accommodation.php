<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Accommodation extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    // todo: relation with calendar

    //todo methods: activate and deactiv
}
