<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 

class Subject extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'name', 'slug', 'code', 'is_active', 'user_create', 'user_update'
    ];

    protected static function boot() {
        parent::boot();
    
        static::deleting(function($subject) {
            $subject->courses()->delete();
        });

        static::restoring(function($subject) {
            $subject->courses()->withTrashed()->restore();
        });
    }


    public function courses () 
    {
        return $this->hasMany('App\Course', 'subject_id', 'id');
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
