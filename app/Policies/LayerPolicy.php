<?php

namespace App\Policies;

use App\User;
use App\Layer;
use Illuminate\Auth\Access\HandlesAuthorization;

class LayerPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any layers.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the layer.
     *
     * @param  \App\User  $user
     * @param  \App\Layer  $layer
     * @return mixed
     */
    public function view(User $user, Layer $layer)
    {
        //
    }

    /**
     * Determine whether the user can create layers.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the layer.
     *
     * @param  \App\User  $user
     * @param  \App\Layer  $layer
     * @return mixed
     */
    public function update(User $user, Layer $layer)
    {
        //
    }

    /**
     * Determine whether the user can delete the layer.
     *
     * @param  \App\User  $user
     * @param  \App\Layer  $layer
     * @return mixed
     */
    public function delete(User $user, Layer $layer)
    {
        return $layer->doesntHaveRelatedModels();
    }

    /**
     * Determine whether the user can restore the layer.
     *
     * @param  \App\User  $user
     * @param  \App\Layer  $layer
     * @return mixed
     */
    public function restore(User $user, Layer $layer)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the layer.
     *
     * @param  \App\User  $user
     * @param  \App\Layer  $layer
     * @return mixed
     */
    public function forceDelete(User $user, Layer $layer)
    {
        //
    }
}
