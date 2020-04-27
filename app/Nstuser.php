<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Nstuser extends Authenticatable
{
    use SoftDeletes;
    use Notifiable;

    protected $guard = 'nst';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email', 
        'role_id',
        'nom',
        'prénom',
        'tel',
        'adress',
        'photo'
    ];

    
    /* The attributes that should be hidden for arrays.
    *
    * @var array
    */
   protected $hidden = [
       'password', 'remember_token',
   ];

   /**
    * The attributes that should be cast to native types.
    *
    * @var array
    */
   protected $casts = [
       'email_verified_at' => 'datetime',
   ];

    public function role()
    {
        return $this->belongsTo('App\Role');
    }
    public function affectations()
    {
        return $this->hasMany('App\Affectation');
    }
}
