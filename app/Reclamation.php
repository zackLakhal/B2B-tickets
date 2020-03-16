<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Reclamation extends Model
{
    use SoftDeletes;
    public function clientuser()
    {
        return $this->belongsTo('App\Clientuser');
    }
    public function souscription()
    {
        return $this->belongsTo('App\Souscription');
    }
    public function affectation()
    {
        return $this->belongsTo('App\Affectation');
    }
    public function etat()
    {
        return $this->belongsTo('App\Etat');
    }
    public function anomalie()
    {
        return $this->belongsTo('App\Anomalie');
    }
}
