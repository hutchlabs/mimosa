<?php

namespace App\Gradlead;

use Illuminate\Database\Eloquent\Model;
use HipsterJazzbo\Landlord\BelongsToTenants;

class Template extends Model
{
    use BelongsToTenants;

    protected $table = 'templates';

    protected $guarded = [];

    protected $hidden = [];
}
