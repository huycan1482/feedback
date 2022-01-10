<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 

class SurveyAnswerDetail extends Model
{
    use SoftDeletes;

    protected $table = 'survey_answer_details';

    protected static function boot() {
        parent::boot();
    
        static::deleting(function($survey_answer_detail) {
        });

        static::restoring(function($survey_answer_detail) {
        });
    }

    public function survey_answer ()
    {
        return $this->belongsTo('App\SurveyAnswerDetail', 'survey_answer_id', 'id');
    }

    public function question ()
    {
        return $this->belongsTo('App\Question', 'question_id', 'id');
    }

    public function answer ()
    {
        return $this->belongsTo('App\Answer', 'answer_id', 'id');
    }   
}
