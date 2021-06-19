<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 

class UserAnswer extends Model
{
    use SoftDeletes;

    protected $table = 'user_answers';

    protected $dates = ['deleted_at'];

}
