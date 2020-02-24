<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Agence extends Model
{
    use SoftDeletes;
    public function clientuser()
    {
        return $this->morphOne('App\Clientuser', 'clientable');
    }

    public function departement()
    {
        return $this->belongsTo('App\Departement');
    }

    public function ville()
    {
        return $this->belongsTo('App\Ville');
    }

    public function produits()
    {
        return $this->belongsToMany('App\Produit');
    }

    public function souscriptions()
    {
        return $this->hasMany('App\Souscription');
    }

}
