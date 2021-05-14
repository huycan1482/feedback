<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FeedBack extends Model
{
    protected $table = 'feedbacks';

    public function question ()
    {
        return $this->belongsToMany('App\Question', 'feedback_question', 'feedback_id', 'question_id')->withPivot('feedback_id', 'question_id');
    }
}
