<?php

namespace App\Gradlead;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Affiliation extends Model
{
    protected $table = 'organizations_employers';

    protected $guarded = [];

    protected $hidden = [];

    protected $with = [];

    public function partner() 
    {
        return $this->belongsTo('\App\Gradlead\Organization','organization_id');
    }    
    
    public function employer() 
    {
        return $this->belongsTo('\App\Gradlead\Organization','employer_id');
    }
}
