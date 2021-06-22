<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 

class UserClass extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    
    protected $table = 'user_class';

    public function user ()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    } 

    public function classRoom ()
    {
        return $this->belongsTo('App\ClassRoom', 'class_id', 'id');
    } 

    public function userCreate ()
    {
        return $this->belongsTo('App\User', 'user_create', 'id');
    }

    public function userUpdate ()
    {
        return $this->belongsTo('App\User', 'user_update', 'id');
    }
}
