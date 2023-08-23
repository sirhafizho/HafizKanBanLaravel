<?php

namespace App\Http\Controllers;

use App\Http\Requests\MoveRequest;
use App\Models\Task;
use App\Models\TaskList;
use App\Http\Requests\TaskRequest;
use App\Models\Workspace;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function store(TaskRequest $request, Workspace $workspace, TaskList $taskList)
    {

        $validatedData = $request->validated();

        $lastTask = $taskList->tasks->last();

        $task = $taskList->tasks()->create([
            'title' => $validatedData['title'],
            'description' => $validatedData['description'],
            'due_date' => $validatedData['due_date'],
            'priority' => $validatedData['priority'],
            'status' => $validatedData['status'],
            'order' => $lastTask ? $lastTask->order + 1 : 1,
        ]);

        return redirect()->route('workspace.show', $taskList->workspace)
            ->with('success', 'Task created successfully.');
    }

    public function update(TaskRequest $request, TaskList $taskList, Task $task)
    {
        $user = $request->user();
        $bool = $task->task_list_id === $taskList->id && $taskList->workspace->user_id === $user->id;

        // Authorize the action using the TaskPolicy
        // $this->authorize('update', [$taskList, $task]);
        if ($bool) {
            // Validate the request data
            $validatedData = $request->validated();

            // // Update the task attributes
            $task->update([
                'title' => $validatedData['title'],
                'description' => $validatedData['description'],
                'due_date' => $validatedData['due_date'],
                'priority' => $validatedData['priority'],
                'status' => $validatedData['status'],
            ]);

            return redirect()->back()->with('success', 'Task updated successfully.');
        } else {
            $this->authorize('update', [$taskList, $task]);
        }
    }

    public function destroy(TaskList $taskList, Task $task)
    {
        $user = auth()->user();
        $bool = $task->task_list_id === $taskList->id && $taskList->workspace->user_id === $user->id;

        if ($bool) {
            // Delete the task
            $task->delete();

            return redirect()->back()->with('success', 'Task deleted successfully.');
        } else {
            // Authorize the action using the TaskPolicy
            $this->authorize('delete', [$taskList, $task]);
        }
    }

    public function moveTask(MoveRequest $request,Task $task)
    {
        $validatedData = $request->validated();
        $newTaskListId = $validatedData['task_list_id'];

        // Update the task's task list and save
        $task->task_list_id = $newTaskListId;
        $task->save();

        return response()->json(['message' => 'Task moved successfully']);
    }
}
