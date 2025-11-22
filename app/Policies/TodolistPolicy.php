<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Todolist;
use Illuminate\Auth\Access\Response;
use Symfony\Component\HttpFoundation\Request;

class TodolistPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Todolist $todolist): Response
    {
        return $user->id === $todolist->user_id
         ? Response::allow()
        : Response::deny('You do not own this part oi.');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Todolist $todolist): Response
    {
       return $user->id === $todolist->user_id
         ? Response::allow()
        : Response::deny('You cannot update this part.');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Todolist $todolist): Response
    {
         return $user->id === $todolist->user_id
         ? Response::allow()
        : Response::deny('You cannot delete this');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Todolist $todolist): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Todolist $todolist): bool
    {
        return false;
    }
}
