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
    public function pending()
    {
        return $this->hasOne('App\Pending');
    }
    public function closed()
    {
        return $this->hasOne('App\Closed');
    }
}

