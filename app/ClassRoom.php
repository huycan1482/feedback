<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 

class ClassRoom extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    
    protected $table = 'classes';

    protected static function boot() {
        parent::boot();
    
        static::deleting(function($classRoom) {
            $classRoom->lessons()->delete();
            $classRoom->user_class()->delete();
            $classRoom->feedback_details()->delete();
        });

        static::restoring(function($classRoom) {
            $classRoom->lessons()->withTrashed()->restore();
            $classRoom->user_class()->withTrashed()->restore();
            $classRoom->feedback_details()->withTrashed()->restore();
        });
    }

    public function user ()
    {
        return $this->belongsTo('App\User', 'teacher_id', 'id');
    }

    public function course ()
    {
        return $this->belongsTo('App\Course', 'course_id', 'id');
    }

    public function student ()
    {
        return $this->belongsToMany('App\User', 'user_class', 'class_id', 'user_id')->withPivot('class_id', 'user_id', 'id');
    }

    public function lessons ()
    {
        return $this->hasMany('App\Lesson', 'class_id', 'id')->orderBy('start_at', 'asc');
    }

    public function feedback ()
    {
        return $this->belongsToMany('App\FeedBack', 'feedback_details', 'class_id', 'feedback_id')->withPivot('class_id', 'feedback_id', 'id');
    }


    public function user_class ()
    {
        return $this->hasMany('App\UserClass', 'class_id', 'id');
    }

    public function feedback_details ()
    {
        return $this->hasMany('App\UserClass', 'class_id', 'id');
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
