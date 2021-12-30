<?php

namespace App\Policies;

use App\User;
use App\Survey;
use Illuminate\Auth\Access\HandlesAuthorization;

class SurveyPolicy
{
    use HandlesAuthorization;
    
    /**
     * Determine whether the user can view any Surveys.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the Survey.
     *
     * @param  \App\User  $user
     * @param  \App\Survey  $Survey
     * @return mixed
     */
    public function view(User $user, Survey $Survey)
    {
        //
    }

    /**
     * Determine whether the user can create Surveys.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the Survey.
     *
     * @param  \App\User  $user
     * @param  \App\Survey  $Survey
     * @return mixed
     */
    public function update(User $user, Survey $Survey)
    {
        //
    }

    /**
     * Determine whether the user can delete the Survey.
     *
     * @param  \App\User  $user
     * @param  \App\Survey  $Survey
     * @return mixed
     */
    public function delete(User $user, Survey $Survey)
    {
        //
    }

    /**
     * Determine whether the user can restore the Survey.
     *
     * @param  \App\User  $user
     * @param  \App\Survey  $Survey
     * @return mixed
     */
    public function restore(User $user)
    {
        return $user->role->name == 'admin';
    }

    /**
     * Determine whether the user can permanently delete the Survey.
     *
     * @param  \App\User  $user
     * @param  \App\Survey  $Survey
     * @return mixed
     */
    public function forceDelete(User $user)
    {
        return $user->role->name == 'admin';
    }
}
