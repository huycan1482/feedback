<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 

class UserAnswer extends Model
{
    use SoftDeletes;

    protected $table = 'user_answers';

    protected $dates = ['deleted_at'];

    protected static function boot() {
        parent::boot();
    
        static::deleting(function($userAnswer) {
            $userAnswer->userAnswer_details()->delete();
        });

        static::restoring(function($userAnswer) {
            $userAnswer->userAnswer_details()->withTrashed()->restore();
        });
    }

    public function userAnswer_details ()
    {
        return $this->hasMany('App\UserAnswer', 'userAnswer_id', 'id');
    }

}
