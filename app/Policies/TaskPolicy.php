<?php

namespace App\Policies;

use App\Models\Task;
use App\Models\TaskList;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TaskPolicy
{

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, TaskList $taskList, Task $task)
    {
        return $task->task_list_id === $taskList->id && $taskList->workspace->user_id === $user->id;
    }

    public function delete(User $user, TaskList $taskList, Task $task)
    {
        return $task->task_list_id === $taskList->id && $taskList->workspace->user_id === $user->id;
    }
}
