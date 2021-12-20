<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes; 

class User extends Authenticatable
{
    use Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'identity_code', 'email', 'role_id', 'password', 'gender', 'address', 'date_of_birth', 'code', 'phone', 'avatar', 'is_active'
    ];

    // protected $guarded = [
    //     'role_id'
    // ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $dates = ['deleted_at'];

    protected static function boot() {
        parent::boot();
    
        static::deleting(function($user) {
            // $user->services()->delete();
            // foreach ($user->classes as $item) {
            //     $item->delete();
            // }
            $user->classes()->delete();

        });

        static::restoring(function($user) {
            $user->classes()->withTrashed()->restore();
        });
    }

    public function role ()
    {
        return $this->belongsTo('App\Role', 'role_id', 'id');
    }

    public function classRooms ()
    {
        return $this->belongsToMany('App\ClassRoom', 'user_class', 'user_id', 'class_id')->withPivot('user_id', 'class_id', 'id');
    }

    public function user_classes ()
    {
        return $this->hasMany('App\UserClass', 'user_id', 'id');
    }

    public function classes ()
    {
        return $this->hasMany('App\ClassRoom', 'teacher_id', 'id');
    }

    public function checkIns ()
    {
        return $this->hasMany('App\CheckIn','user_id', 'id');
    }

    public function user_answers () 
    {
        return $this->hasMany('App\UserAnswer','user_id', 'id');
    }
    
}
