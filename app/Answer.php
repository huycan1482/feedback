<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 

class Answer extends Model
{
    use SoftDeletes;

    /**
      * The attributes that are mass assignable.
      *
      * @var array
      */
    protected $fillable = [
        'code', 'content', 'point'
    ];

     /**
      * The attributes that aren't mass assignable.
      *
      * @var array
      */
    // protected $guarded = ['price'];

    protected $dates = ['deleted_at'];

    protected static function boot() {
        parent::boot();
    
        static::deleting(function($answer) {
            $answer->user_answers()->delete();
        });

        static::restoring(function($answer) {
            $answer->user_answers()->withTrashed()->restore();
        });
    }

    public function user_answers ()
    {
        return $this->hasMany('App\UserAnswer', 'answer_id', 'id');
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
