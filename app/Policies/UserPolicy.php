<?php

namespace App\Policies;

use App\ClassRoom;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;
    
    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $user
     * @param  \App\User  $model
     * @return mixed
     */
    public function view(User $user, User $model)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {

    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\User  $model
     * @return mixed
     */
    public function update(User $user, User $model)
    {
        return $user->id == $model->id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\User  $model
     * @return mixed
     */
    public function delete(User $user, User $model)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\User  $user
     * @param  \App\User  $model
     * @return mixed
     */
    public function restore(User $user)
    {
        return $user->role->name == 'admin';
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\User  $model
     * @return mixed
     */
    public function forceDelete(User $user)
    {
        return $user->role->name == 'admin';
    }

    public function checkAdmin (User $user)
    {
        return $user->role->name == 'admin';
    }

    public function viewCheckIn(User $user)
    {
        return $user->role->name == 'teacher';
    }

    public function postCheckIn(User $user, ClassRoom $classRoom)
    {
        return $classRoom->teacher_id == $user->id;
    }

    public function viewFeedBack(User $user)
    {
        return $user->role->name == 'user';
    }

    public function postFeedBack (User $user)
    {
        return $user->role->name == 'user';
    }
}
