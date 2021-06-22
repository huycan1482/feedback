<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 

class FeedbackQuestion extends Model
{
    use SoftDeletes;

    protected $table = 'feedback_question';

    protected $dates = ['deleted_at'];

    public function userCreate ()
    {
        return $this->belongsTo('App\User', 'user_create', 'id');
    }

    public function userUpdate ()
    {
        return $this->belongsTo('App\User', 'user_update', 'id');
    }

}
