<?php

namespace App\Gradlead;

use App\Gradlead\BaseModel;

class Test extends BaseModel
{
    protected $table = 'ztest';

    protected $guarded = [];

    protected $hidden = [];

    protected $with = ['organization'];

    public function organization()
    {
        return $this->belongsTo('\App\Gradlead\Organization');
    }

}
