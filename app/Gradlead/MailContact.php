<?php

namespace App\Gradlead;

use Illuminate\Database\Eloquent\Model;
use HipsterJazzbo\Landlord\BelongsToTenants;

class MailContact extends Model
{
    use BelongsToTenants;

    protected $table = 'mailing_list';

    protected $guarded = [];

    protected $hidden = [];
}
