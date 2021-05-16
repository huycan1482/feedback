<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClassRoom extends Model
{
    protected $table = 'classes';

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

    public function lesson ()
    {
        return $this->hasMany('App\Lesson', 'class_id', 'id')->orderBy('start_at', 'asc');
    }
}
