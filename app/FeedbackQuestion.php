<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 

class FeedbackQuestion extends Model
{
    use SoftDeletes;

    protected $table = 'feedback_question';

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'question_id', 'feedback_id', 'position', 'user_create', 'user_update',
    ];

    public function userCreate ()
    {
        return $this->belongsTo('App\User', 'user_create', 'id');
    }

    public function userUpdate ()
    {
        return $this->belongsTo('App\User', 'user_update', 'id');
    }

}
