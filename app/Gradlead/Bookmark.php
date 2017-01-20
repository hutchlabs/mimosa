<?php

namespace App\Gradlead;

use Illuminate\Database\Eloquent\Model;

class Bookmark extends Model
{
    protected $table = 'users_bookmarks';

    protected $guarded = [];

    protected $hidden = [];
}
