<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 

class Question extends Model
{
    use SoftDeletes;

    protected static function boot() {
        parent::boot();
    
        static::deleting(function($question) {
            $question->answers()->delete();
            $question->feedback_question()->delete();
            $question->user_answers()->delete();
        });

        static::restoring(function($question) {
            $question->answers()->withTrashed()->restore();
            $question->feedback_question()->withTrashed()->restore();
            $question->user_answers()->withTrashed()->restore();
        });
    }

    public function answers ()
    {
        return $this->hasMany('App\Answer', 'question_id', 'id');
    }
    
    public function feedback_question ()
    {
        return $this->hasMany('App\FeedbackQuestion', 'question_id', 'id');
    }

    public function user_answers ()
    {
        return $this->hasMany('App\UserAnswer', 'question_id', 'id');
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
