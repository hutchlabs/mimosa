<?php

namespace App\Gradlead;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'system_roles';

    protected $guarded = [];

    protected $hidden = [];
}
