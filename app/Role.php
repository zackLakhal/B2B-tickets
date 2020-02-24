<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Role extends Model
{
    use SoftDeletes;
    public function clientusers()
    {
        return $this->hasMany('App\Clientuser');
    }
    public function nstusers()
    {
        return $this->hasMany('App\Nstuser');
    }
}
