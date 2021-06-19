<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 

class Role extends Model
{
    use SoftDeletes;

    protected static function boot() {
        parent::boot();
    
        static::deleting( function ($role) {
            $role->users()->delete();
        });

        static::restoring( function ($role) {
            $role->users()->withTrashed()->restore();
        });
    }

    public function users () 
    {
        return $this->hasMany('App\User', 'role_id', 'id');
    }
}
