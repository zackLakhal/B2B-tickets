<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Client extends Model
{
    use SoftDeletes;
    public function departements()
    {
        return $this->hasMany('App\Departement');
    }

    public function clientuser()
    {
        return $this->morphOne('App\Clientuser', 'clientable');
    }
}
