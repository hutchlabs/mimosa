<?php

namespace App\Gradlead;

use Illuminate\Database\Eloquent\Model;
use HipsterJazzbo\Landlord\BelongsToTenants;

class Event extends Model
{
    use BelongsToTenants;

    protected $table = 'events';

    protected $guarded = [];

    protected $hidden = [];
}
