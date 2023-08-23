<?php

namespace App\Http\Controllers;

use App\Models\Workspace;
use App\Http\Requests\WorkspaceRequest;
use Illuminate\Support\Facades\Log;

class WorkspaceController extends Controller
{
    public function show(Workspace $workspace)
    {
        // Authorize the user to view the workspace
        $this->authorize('view', $workspace);

        return view('workspace', compact('workspace'));
    }

    public function index()
    {
        $user = auth()->user();
        $workspaces = $user->workspaces;
        return view('workspaces.index', compact('workspaces'));
    }

    public function create()
    {
        return view('workspaces.create');
    }

    public function store(WorkspaceRequest $request)
    {
        $user = $request->user();

        $validatedData = $request->validated();

        $workspace = $user->workspaces()->create([
            'name' => $validatedData['name'],
            'description' => $validatedData['description'],
            'color' => 'none', // Default color
            'order' => $user->workspaces->count() + 1, // Increment by 1
        ]);

        // Add a log statement to check if the workspace was created successfully
        Log::info("Workspace created: {$workspace->name}");


        return redirect()->route('dashboard')
            ->with('success', 'Workspace created successfully.');
    }

    public function edit(Workspace $workspace)
    {
        return view('workspaces.edit', compact('workspace'));
    }

    public function update(WorkspaceRequest $request, Workspace $workspace)
    {
        $validatedData = $request->validated();

        $workspace->update([
            'name' => $validatedData['name'],
            'description' => $validatedData['description'],
        ]);

        return redirect()->route('dashboard')
            ->with('success', 'Workspace updated successfully.');
    }

    public function destroy(Workspace $workspace)
    {
        // Delete the workspace
        $workspace->delete();

        // After deletion, update order values of remaining workspaces
        $user = auth()->user();
        $user->workspaces->each(function ($workspace, $index) {
            $workspace->update(['order' => $index + 1]);
        });

        return redirect()->route('dashboard')
            ->with('success', 'Workspace deleted successfully.');
    }

    public function showWorkspace($id)
    {

        // Find the workspace by its ID
        $workspace = Workspace::findOrFail($id);

        // Check if the current user has permission to view the workspace
        $this->authorize('view', $workspace);

        $taskLists = $workspace->taskLists; // Load the associated TaskLists

        // Load other data you need for the workspace page
        return view('workspace', compact('workspace', 'taskLists'));
    }
}
