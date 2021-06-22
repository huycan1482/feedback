<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 

class Course extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected static function boot() {
        parent::boot();
    
        static::deleting(function($course) {
            $course->classes()->delete();
        });

        static::restoring(function($course) {
            $course->classes()->withTrashed()->restore();
        });
    }

    public function classes ()
    {
        return $this->hasMany('App\ClassRoom', 'course_id', 'id');
    }

    public function subject ()
    {
        return $this->belongsTo('App\Subject', 'subject_id', 'id');
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
