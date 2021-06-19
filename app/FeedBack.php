<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 

class FeedBack extends Model
{
    use SoftDeletes;

    protected $table = 'feedbacks';

    protected static function boot() {
        parent::boot();
    
        static::deleting(function($feedback) {
            $feedback->feedback_details()->delete();
            $feedback->feedback_question()->delete();
        });

        static::restoring(function($feedback) {
            $feedback->feedback_details()->withTrashed()->restore();
            $feedback->feedback_question()->withTrashed()->restore();
        });
    }

    public function question ()
    {
        return $this->belongsToMany('App\Question', 'feedback_question', 'feedback_id', 'question_id')
            ->withPivot('feedback_id', 'question_id')
            ->orderBy('feedback_question.position', 'desc')
            ->orderBy('feedback_question.id', 'asc');
    }

    public function feedback_details ()
    {
        return $this->hasMany('App\FeedbackDetail', 'feedback_id', 'id');
    }

    public function feedback_question ()
    {
        return $this->hasMany('App\FeedbackQuestion', 'feedback_id', 'id');
    }
}
