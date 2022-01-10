<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 

class Survey extends Model
{
    use SoftDeletes;
    
    protected $table = 'surveys';

    protected $fillable = [
        'code', 'feedback_id', 'start_at', 'end_at', 'is_active', 'created_at', 'updated_at'
    ];

    protected static function boot() {
        parent::boot();
    
        static::deleting(function($survey) {
            $survey->survey_answers()->delete();
        });

        static::restoring(function($survey) {
            $survey->survey_answers()->withTrashed()->restore();
        });
    }

    public function feedback () 
    {
        return $this->belongsTo('App\Feedback', 'feedback_id', 'id');
    }

    public function survey_answers () 
    {
        return $this->hasMany('App\SurveyAnswer', 'survey_id', 'id');
    }

    public function anonymous_users ()
    {
        return $this->belongsToMany('App\AnonymousUser', 'survey_answers', 'survey_id', 'anonymous_user_id');
    }

}
