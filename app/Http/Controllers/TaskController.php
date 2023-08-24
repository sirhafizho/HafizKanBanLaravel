<?php

namespace App\Http\Controllers;

use App\Http\Requests\MoveRequest;
use App\Models\Task;
use App\Models\TaskList;
use App\Http\Requests\TaskRequest;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function store(TaskRequest $request, TaskList $taskList)
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

    public function moveTask(MoveRequest $request, Task $task)
    {
        $validatedData = $request->validated();
        $newTaskListId = $validatedData['task_list_id'];

        // Retrieve the original task attributes
        $originalAttributes = $task->toArray();

        // Create a new task in the target task list
        $newTask = new Task();
        $newTask->fill($originalAttributes);
        $newTaskList = TaskList::findOrFail($newTaskListId);

        $lastTask = $newTaskList->tasks->last();
        $newTask->order = $lastTask ? $lastTask->order + 1 : 1; // Set the order

        $newTaskArray = $newTask->toArray();
        unset($newTaskArray['task_list_id']);
        $newTaskList->tasks()->create($newTaskArray);

        // $newTask->save();

        // Delete the original task
        $task->delete();

        return redirect()->route('workspace.show', $newTaskList->workspace)
            ->with('success', 'Task moved successfully.');
        // return response()->json(['message' => 'Task moved successfully']);
    }

    public function moveTaskDrop(Request $request)
    {
        $task_id = $request->input('task_id');
        $new_task_list_id = $request->input('new_task_list_id');


        $task = Task::findOrFail($task_id);
        $newTaskList = TaskList::findOrFail($new_task_list_id);

        $originalAttributes = $task->toArray();

        $newTask = new Task();
        $newTask->fill($originalAttributes);

        $lastTask = $newTaskList->tasks->last();
        $newTask->order = $lastTask ? $lastTask->order + 1 : 1; // Set the order

        $newTaskArray = $newTask->toArray();
        unset($newTaskArray['task_list_id']);

        $newTaskList->tasks()->create($newTaskArray);

        $task->delete();

        return response()->json(['message' => 'Task moved successfully']);
    }
}
