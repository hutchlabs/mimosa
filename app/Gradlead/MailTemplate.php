<?php

namespace App\Gradlead;

use Illuminate\Database\Eloquent\Model;
use HipsterJazzbo\Landlord\BelongsToTenants;

class MailTemplate extends Model
{
    use BelongsToTenants;

    protected $table = 'mailing_templates';

    protected $guarded = [];

    protected $hidden = [];
}
