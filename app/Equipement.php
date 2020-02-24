<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
class Equipement extends Model
{
    public function produit()
    {
        return $this->belongsTo('App\Produit');
    }
    public function souscriptions()
    {
        return $this->hasMany('App\Souscription');
    }
}
