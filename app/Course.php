<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    public function subject ()
    {
        return $this->belongsTo('App\Subject', 'subject_id', 'id');
    }
}
