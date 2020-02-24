<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Departement extends Model
{
    use SoftDeletes;
    public function clientuser()
    {
        return $this->morphOne('App\Clientuser', 'clientable');
    }
    public function agences()
    {
        return $this->hasMany('App\Agence');
    }
    public function client()
    {
        return $this->belongsTo('App\Client');
    }
}
