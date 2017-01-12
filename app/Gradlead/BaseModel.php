<?php

namespace App\Gradlead;

use Illuminate\Database\Eloquent\Model;
use HipsterJazzbo\Landlord\BelongsToTenants;

class BaseModel extends Model
{
      use BelongsToTenants;
}
