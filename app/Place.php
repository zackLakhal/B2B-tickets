<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Place extends Model
{
    public function ville()
    {
        return $this->belongsTo('App\Ville');
    }
    public function added_By()
    {
        return $this->belongsTo('App\User');
    }
    public function reactions()
    {
        return $this->belongsToMany('App\User');
    }
    public function photos()
    {
        return $this->HasMany('App\Photo');
    }
    public function comments()
    {
        return $this->hasMany('App\Comment');
    }
}
