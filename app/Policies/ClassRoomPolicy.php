<?php

namespace App\Policies;

use App\User;
use App\ClassRoom;
use Illuminate\Auth\Access\HandlesAuthorization;

class ClassRoomPolicy
{
    use HandlesAuthorization;
    
    /**
     * Determine whether the user can view any class rooms.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the class room.
     *
     * @param  \App\User  $user
     * @param  \App\ClassRoom  $classRoom
     * @return mixed
     */
    public function view(User $user, ClassRoom $classRoom)
    {
        //
    }

    /**
     * Determine whether the user can create class rooms.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the class room.
     *
     * @param  \App\User  $user
     * @param  \App\ClassRoom  $classRoom
     * @return mixed
     */
    public function update(User $user, ClassRoom $classRoom)
    {
        //
    }

    /**
     * Determine whether the user can delete the class room.
     *
     * @param  \App\User  $user
     * @param  \App\ClassRoom  $classRoom
     * @return mixed
     */
    public function delete(User $user, ClassRoom $classRoom)
    {
        //
    }

    /**
     * Determine whether the user can restore the class room.
     *
     * @param  \App\User  $user
     * @param  \App\ClassRoom  $classRoom
     * @return mixed
     */
    public function restore(User $user)
    {
        return $user->role->name == 'admin';
        
    }

    /**
     * Determine whether the user can permanently delete the class room.
     *
     * @param  \App\User  $user
     * @param  \App\ClassRoom  $classRoom
     * @return mixed
     */
    public function forceDelete(User $user)
    {
        return $user->role->name == 'admin';
        
    }
}
