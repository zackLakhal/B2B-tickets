<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Equipement extends Model
{   
    use SoftDeletes;
    public function produit()
    {
        return $this->belongsTo('App\Produit');
    }
    public function souscriptions()
    {
        return $this->hasMany('App\Souscription');
    }
}
