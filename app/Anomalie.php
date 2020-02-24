<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Anomalie extends Model
{
    use SoftDeletes;
    public function reclamations()
    {
        return $this->hasMany('App\Reclamation');
    }
}
