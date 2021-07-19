<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 

class Lesson extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected static function boot() {
        parent::boot();
    
        static::deleting(function($lesson) {
            $lesson->checkIns()->delete();

        });

        static::restoring(function($lesson) {
            $lesson->checkIns()->withTrashed()->restore();
        });
    }
    
    public function checkIns ()
    {
        return $this->hasMany('App\CheckIn','lesson_id', 'id');
    }

}
