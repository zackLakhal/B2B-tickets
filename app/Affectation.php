<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Affectation extends Model
{
    public function reclamation()
    {
        return $this->hasOne('App\Reclamation');
    }

    public function nstuser()
    {
        return $this->belongsTo('App\Nstuser');
    }
    public function raport()
    {
        return $this->hasOne('App\Raport');
    }
}

