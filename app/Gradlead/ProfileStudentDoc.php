<?php

namespace App\Gradlead;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ProfileStudentDoc extends Model
{
    protected $table = 'profiles_student_docs';

    protected $guarded = [];

    protected $hidden = [];
}
