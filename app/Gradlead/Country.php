<?php

namespace App\Gradlead;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $table = 'system_countries';

    protected $guarded = [];

    protected $hidden = [];
}
