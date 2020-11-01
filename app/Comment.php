<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    public function place()
    {
        return $this->belongsTo('App\place');
    }
    public function user()
    {
        return $this->belongsTo('App\user');
    }
}
