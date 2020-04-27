<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Clientuser extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;
    protected $guard = 'client';

    protected $fillable = [
        'name',
        'email', 
        'clientable_id',
        'clientable_type',
        'role_id',
        'nom',
        'prénom',
        'tel',
        'adress',
        'photo',
        'created_by'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];
    
    public function clientable()
    {
        return $this->morphTo();
    }

    public function role()
    {
        return $this->belongsTo('App\Role');
    }

    public function reclamations()
    {
        return $this->hasMany('App\Reclamation');
    }
}
