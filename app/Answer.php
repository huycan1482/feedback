<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 

class Answer extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected static function boot() {
        parent::boot();
    
        static::deleting(function($answer) {
            $answer->user_answers()->delete();
        });

        static::restoring(function($answer) {
            $answer->user_answers()->withTrashed()->restore();
        });
    }

    public function user_answers ()
    {
        return $this->hasMany('App\UserAnswer', 'answer_id', 'id');
    }
}
