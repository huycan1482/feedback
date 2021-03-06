<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 

class FeedBack extends Model
{
    use SoftDeletes;

    protected $table = 'feedbacks';

    protected $fillable = [
        'name', 'slug', 'code', 'time', 'is_active', 'is_public', 'user_create', 'user_update', 'created_at', 'updated_at'
    ];

    protected static function boot() {
        parent::boot();
    
        static::deleting(function($feedback) {
            $feedback->feedback_details()->delete();
            $feedback->feedback_question()->delete();
            $feedback->surveys()->delete();
        });

        static::restoring(function($feedback) {
            $feedback->feedback_details()->withTrashed()->restore();
            $feedback->feedback_question()->withTrashed()->restore();
            $feedback->surveys()->withTrashed()->restore();
        });
    }

    public function question ()
    {
        return $this->belongsToMany('App\Question', 'feedback_question', 'feedback_id', 'question_id')
            ->withPivot('feedback_id', 'question_id')
            ->orderBy('feedback_question.position', 'desc')
            ->orderBy('feedback_question.id', 'asc');
    }

    public function classRoom ()
    {
        return $this->belongsToMany('App\ClassRoom', 'feedback_details', 'feedback_id', 'class_id')
            ->withPivot('id', 'feedback_id', 'class_id');
    }

    public function feedback_details ()
    {
        return $this->hasMany('App\FeedbackDetail', 'feedback_id', 'id');
    }

    public function feedback_question ()
    {
        return $this->hasMany('App\FeedbackQuestion', 'feedback_id', 'id');
    }

    public function userCreate ()
    {
        return $this->belongsTo('App\User', 'user_create', 'id');
    }

    public function userUpdate ()
    {
        return $this->belongsTo('App\User', 'user_update', 'id');
    }

    public function surveys () 
    {
        $this->hasMany('App\Survey', 'feedback_id', 'id');
    }
}
