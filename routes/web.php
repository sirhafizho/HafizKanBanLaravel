<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WorkspaceController;
use App\Http\Controllers\TaskListController;
use App\Http\Controllers\TaskController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $user = auth()->user();
    $workspaces = $user->workspaces;
    return view('dashboard', compact('workspaces'));
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/workspaces/create', [WorkspaceController::class, 'create'])->name('workspaces.create');
    Route::post('/workspaces', [WorkspaceController::class, 'store'])->name('workspaces.store');
    Route::get('/workspaces/{workspace}/edit', [WorkspaceController::class, 'edit'])->name('workspaces.edit');
    Route::patch('/workspaces/{workspace}', [WorkspaceController::class, 'update'])->name('workspaces.update');
    Route::delete('/workspaces/{workspace}', [WorkspaceController::class, 'destroy'])->name('workspaces.destroy');
    Route::get('/workspace/{id}', [WorkspaceController::class, 'showWorkspace'])->name('workspace.show');

    Route::post('/workspaces/{workspace}/tasklists', [TaskListController::class, 'store'])
        ->name('tasklists.store');
    Route::patch('/workspaces/{workspace}/tasklists/{taskList}', [TaskListController::class, 'update'])
        ->name('tasklists.update');
    Route::delete('/workspaces/{workspace}/tasklists/{tasklist}', [TaskListController::class, 'destroy'])
        ->name('tasklists.destroy');

    Route::post('tasklists/{taskList}/tasks', [TaskController::class, 'store'])
        ->name('task.store');
    Route::patch('tasklists/{taskList}/tasks/{task}', [TaskController::class, 'update'])
        ->name('task.update');
    Route::delete('tasklists/{taskList}/tasks/{task}', [TaskController::class, 'destroy'])
        ->name('task.destroy');

    Route::post('/move-task/{task}', [TaskController::class, 'moveTask'])->name('task.move');
    Route::post('/move-task-drop', [TaskController::class, 'moveTaskDrop'])->name('task.drop');
});


require __DIR__ . '/auth.php';
