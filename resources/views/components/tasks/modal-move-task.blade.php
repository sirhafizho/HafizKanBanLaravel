<form method="POST" action="{{ route('move-task', ['task' => $task]) }}">
    @csrf
    <div class="modal fade" id="moveTask{{ $task->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content bg-dark">
                <div class="modal-header">
                    <h5 class="modal-title text-white" id="modalCenterTitle">Move Task</h5>
                    <button type="button" class="btn-close bg-dark" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col mb-3">
                            <label for="newTaskId" class="form-label text-white">Move Task to:</label>
                            <select required id="newTaskId" name="task_list_id" class="form-select bg-dark text-white">
                                @foreach ($taskLists as $taskList)
                                    <option value="{{ $taskList->id }}">{{ $taskList->title }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        Close
                    </button>
                    <button type="submit" class="btn btn-primary" style="background-color: #696cff;">Save</button>
                </div>
            </div>
        </div>
    </div>
</form>
