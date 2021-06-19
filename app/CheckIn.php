<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 

class CheckIn extends Model
{
    use SoftDeletes;

    protected $table = 'check_in';

    protected $dates = ['deleted_at'];

}
