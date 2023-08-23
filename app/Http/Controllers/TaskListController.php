<?php

namespace App\Http\Controllers;

use App\Models\TaskList;
use App\Http\Requests\TaskListRequest;
use App\Models\Workspace;

class TaskListController extends Controller
{
    public function index()
    {
        // Retrieve task lists for the current user's workspace
        $taskLists = auth()->user()->currentWorkspace->taskLists;

        return view('task_lists.index', compact('taskLists'));
    }

    public function store(TaskListRequest $request, Workspace $workspace)
    {
        $validatedData = $request->validated();

        $user = $request->user();

        $lastTaskList = $user->taskLists->last();


        $taskList = $user->taskLists()->create([
            'title' => $validatedData['title'],
            'color' => 'none', // Default color
            'description' => '', // Default empty description
            'position' => $lastTaskList ? $lastTaskList->position + 1 : 1,
            'workspace_id' => $workspace->id, // You need to include workspace_id in your request
        ]);

        return redirect()->route('workspace.show', $workspace)
            ->with('success', 'Task list created successfully.');
    }


    public function update(TaskListRequest $request, Workspace $workspace, TaskList $taskList)
    {
        $validatedData = $request->validated();

        $taskList->update([
            'title' => $validatedData['title'],
            // You can include other fields to update here if needed
        ]);

        return redirect()->route('workspace.show', $workspace)
            ->with('success', 'Task list updated successfully.');
    }

    public function destroy(Workspace $workspace, TaskList $tasklist)
    {


        // // Adjust the positions of other task lists
        $taskListsToUpdate = $workspace->taskLists()
            ->whereColumn('position', '>', $tasklist->position)
            ->get();

        foreach ($taskListsToUpdate as $list) {
            $list->update(['position' => $list->position - 1]);
        }

        // Delete the task list
        $tasklist->delete();


        return redirect()->route('workspace.show', $workspace)
            ->with('success', 'Task list deleted successfully.');
    }
}
