<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 

class FeedbackDetail extends Model
{
    use SoftDeletes;

    protected $table = 'feedback_details';

    protected $dates = ['deleted_at'];

    protected static function boot() {
        parent::boot();
    
        static::deleting(function($feedback_details) {
            $feedback_details->user_answers()->delete();
        });

        static::restoring(function($feedback_details) {
            $feedback_details->user_answers()->withTrashed()->restore();
        });
    }

    public function user_answers ()
    {
        return $this->hasMany('App\UserAnswer', 'feedBackDetail_id', 'id');
    }


    public function userCreate ()
    {
        return $this->belongsTo('App\User', 'user_create', 'id');
    }

    public function userUpdate ()
    {
        return $this->belongsTo('App\User', 'user_update', 'id');
    }


    public function feedback ()
    {
        return $this->belongsTo('App\FeedBack', 'feedback_id', 'id');
    }

}
