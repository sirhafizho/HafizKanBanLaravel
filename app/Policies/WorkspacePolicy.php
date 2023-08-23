<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Workspace;

class WorkspacePolicy
{
    /**
     * Determine if the given user can view the workspace.
     */
    public function view(User $user, Workspace $workspace)
    {
        return $user->id === $workspace->user_id;
    }

    /**
     * Determine if the given user can update the workspace.
     */
    public function update(User $user, Workspace $workspace)
    {
        return $user->id === $workspace->user_id;
    }

    /**
     * Determine if the given user can delete the workspace.
     */
    public function delete(User $user, Workspace $workspace)
    {
        return $user->id === $workspace->user_id;
    }
}
