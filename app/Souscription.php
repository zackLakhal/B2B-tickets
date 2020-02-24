<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Souscription extends Model
{
    use SoftDeletes;

    public function agence()
    {
        return $this->belongsTo('App\Agence');
    }
    public function produit()
    {
        return $this->belongsTo('App\Produit');
    }
    public function equipement()
    {
        return $this->belongsTo('App\Equipement');
    }
}
