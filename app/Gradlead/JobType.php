<?php

namespace App\Gradlead;

use Illuminate\Database\Eloquent\Model;

class JobType extends Model
{
    protected $table = 'system_job_types';

    protected $guarded = [];

    protected $hidden = [];
}
