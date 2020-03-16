<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Souscription extends Model
{

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
    public function reclamations()
    {
        return $this->hasMany('App\Reclamation');
    }
}
