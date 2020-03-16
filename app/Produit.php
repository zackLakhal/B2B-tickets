<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Produit extends Model
{
    use SoftDeletes;
    
    public function agences()
    {
        return $this->belongsToMany('App\Agence');
    }
    public function equipements()
    {
        return $this->hasMany('App\Equipement');
    }
    public function souscriptions()
    {
        return $this->hasMany('App\Souscription');
    }
}
