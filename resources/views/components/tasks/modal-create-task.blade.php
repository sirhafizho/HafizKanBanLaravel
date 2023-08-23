<!-- Modal -->
<style>
    /* Style the calendar icon */
    input[type="datetime-local"]::-webkit-calendar-picker-indicator {
        filter: invert(1);
    }
</style>

<form method="POST" action="{{ route('task.store', ['workspace' => $workspace, 'taskList' => $taskList]) }}">
    @csrf
    <div class="modal fade" id="createTaskModal{{ $taskList->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content bg-dark">
                <div class="modal-header">
                    <h5 class="modal-title text-white" id="modalCenterTitle">Create Task</h5>
                    <button type="button" class="btn-close bg-dark" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col mb-3">
                            <label for="taskTitle" class="form-label text-white">Task Title</label>
                            <input required type="text" id="taskTitle" name="title"
                                class="form-control bg-dark text-white" placeholder="Enter Task Title" />
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>
                    </div>
                    <div class="row g-2">
                        <div class="col mb-0">
                            <label for="taskDescription" class="form-label text-white">Task Description
                                (optional)</label>
                            <textarea id="taskDescription" name="description" class="form-control bg-dark text-white"
                                placeholder="Enter Task Description" rows="4" cols="50"></textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label for="dueDate" class="form-label text-white">Due Date</label>
                            <input name="due_date" required id="dueDate" class="form-control bg-dark text-white" type="datetime-local"
                                value="2023-08-24T12:30:00" />
                            <x-input-error :messages="$errors->get('due_date')" class="mt-2" />
                        </div>
                        <div class="col mb-3">
                            <label for="priority" class="form-label text-white">Priority</label>
                            <select required id="priority" name="priority" class="form-select bg-dark text-white">
                                <option value="low">Low</option>
                                <option value="medium">Medium</option>
                                <option value="high">High</option>
                            </select>
                            <x-input-error :messages="$errors->get('priority')" class="mt-2" />
                        </div>
                        <div class="col mb-3">
                            <label for="status" class="form-label text-white">Status</label>
                            <select required id="status" name="status" class="form-select bg-dark text-white">
                                <option value="incomplete">Incomplete</option>
                                <option value="completed">Completed</option>
                            </select>
                            <x-input-error :messages="$errors->get('status')" class="mt-2" />
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        Close
                    </button>
                    <button type="submit" class="btn btn-primary" style="background-color: #696cff;">Create
                        Task</button>
                </div>
            </div>
        </div>
    </div>
</form>
