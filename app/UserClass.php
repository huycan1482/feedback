<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserClass extends Model
{
    protected $table = 'user_class';

    public function user ()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    } 

    public function classRoom ()
    {
        return $this->belongsTo('App\ClassRoom', 'class_id', 'id');
    } 
}
