<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 

class SurveyAnswer extends Model
{
    use SoftDeletes;

    protected $table = 'survey_answers';

    protected static function boot() {
        parent::boot();
    
        static::deleting(function($survey_answer) {
            $survey_answer->survey_answer_details()->delete();
        });

        static::restoring(function($survey_answer) {
            $survey_answer->survey_answer_details()->withTrashed()->restore();
        });
    }

    public function survey () 
    {
        return $this->belongsTo('App\Survey', 'survey_id', 'id');
    }

    public function anonymous_user () 
    {
        return $this->belongsTo('App\AnonymousUser', 'anonymous_user_id', 'id');
    }

    public function survey_answer_details () 
    {
        return $this->hasMany('App\SurveyAnswerDetail', 'survey_answer_id', 'id');
    }
}
