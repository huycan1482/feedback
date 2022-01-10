<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 

class AnonymousUser extends Model
{
    use SoftDeletes;

    protected $table = 'anonymous_users';

    protected static function boot() {
        parent::boot();
    
        static::deleting(function($anonymous_user) {
            $anonymous_user->survey_answers()->delete();
        });

        static::restoring(function($anonymous_user) {
            $anonymous_user->survey_answers()->withTrashed()->restore();
        });
    }

    public function user () 
    {
        return $this->belongsTo('App\User', 'user_identity', 'id');
    }

    public function survey_answers ()
    {
        return $this->hasMany('App\SurveyAnswer', 'anonymous_user_id', 'id');
    }
}
