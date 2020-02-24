<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Ville extends Model
{
    use SoftDeletes;
    
    public function agences()
    {
        return $this->hasMany('App\Agence');
    }
}
