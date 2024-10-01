<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class UsersPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): Response
    {
        return $user->profile === "admin" 
                    ? Response::allow() 
                    : Response::deny("You don't have admin profile");
    }

    /**
     * Determine whether the user can view the model.
     */
    public function viewEmployee(User $user, User $employee): Response
    {
        return $user->id == $employee->id_gestor
                   ? Response::allow() 
                   : Response::deny("You don't created the user and cannot view");
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): Response
    {
        return $user->profile == "admin"
                    ? Response::allow() 
                    : Response::deny("You don't have admin profile");
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user): Response
    {
        return $user->profile == "admin"
                    ? Response::allow() 
                    : Response::deny("You don't have admin profile");
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user): Response
    {
        return $user->profile == "admin"
                    ? Response::allow() 
                    : Response::deny("You don't have admin profile");
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user): Response
    {
        return $user->profile == "admin"
                    ? Response::allow() 
                    : Response::deny("You don't have admin profile");
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user): Response
    {
        return $user->profile == "admin"
                    ? Response::allow() 
                    : Response::deny("You don't have admin profile");
    }
}
