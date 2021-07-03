<?php

namespace App\Policies;

use App\User;
use App\FeedBack;
use Illuminate\Auth\Access\HandlesAuthorization;

class FeedBackPolicy
{
    use HandlesAuthorization;
    
    /**
     * Determine whether the user can view any feed backs.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the feed back.
     *
     * @param  \App\User  $user
     * @param  \App\FeedBack  $feedBack
     * @return mixed
     */
    public function view(User $user, FeedBack $feedBack)
    {
        //
    }

    /**
     * Determine whether the user can create feed backs.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the feed back.
     *
     * @param  \App\User  $user
     * @param  \App\FeedBack  $feedBack
     * @return mixed
     */
    public function update(User $user, FeedBack $feedBack)
    {
        //
    }

    /**
     * Determine whether the user can delete the feed back.
     *
     * @param  \App\User  $user
     * @param  \App\FeedBack  $feedBack
     * @return mixed
     */
    public function delete(User $user, FeedBack $feedBack)
    {
        //
    }

    /**
     * Determine whether the user can restore the feed back.
     *
     * @param  \App\User  $user
     * @param  \App\FeedBack  $feedBack
     * @return mixed
     */
    public function restore(User $user)
    {
        return $user->role->name == 'admin';
    }

    /**
     * Determine whether the user can permanently delete the feed back.
     *
     * @param  \App\User  $user
     * @param  \App\FeedBack  $feedBack
     * @return mixed
     */
    public function forceDelete(User $user)
    {
        return $user->role->name == 'admin';
    }
}
