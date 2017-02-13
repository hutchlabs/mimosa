<?php

namespace App\Gradlead;

use Illuminate\Database\Eloquent\Model;
use HipsterJazzbo\Landlord\BelongsToTenants;

class Theme extends Model
{
    use BelongsToTenants;

    protected $table = 'themes';

    protected $guarded = [];

    protected $hidden = [];
}
