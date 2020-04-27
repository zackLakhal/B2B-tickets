<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Raport extends Model
{
    use SoftDeletes;
    public function affectation()
    {
        return $this->belongsTo('App\Affectation');
    }
}
