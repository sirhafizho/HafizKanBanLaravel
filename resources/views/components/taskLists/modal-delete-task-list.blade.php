<form method="POST" action="{{ route('tasklists.destroy', ['workspace' => $workspace, 'tasklist' => $taskList]) }}"
    class="d-inline">
    @csrf
    @method('DELETE')
    <div class="modal fade" id="deleteTaskList{{ $taskList->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content bg-dark">
                <div class="modal-header">
                    <h5 class="modal-title text-white" id="modalCenterTitle">Delete Task List - {{ $taskList->title }}
                    </h5>
                    <button type="button" class="btn-close bg-dark" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h3 class="text-white">Are you sure you want to delete {{ $taskList->title }}?</h3>
                    <h3 class="mt-2" style="color: #ff3e1d;font-weight:bold">Deleting this task list will delete all
                        of task within
                        this task list*</h3>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        Cancel
                    </button>

                    <button type="submit" class="btn btn-danger" style="background-color: #ff3e1d;">Delete</button>
                </div>
            </div>
        </div>
    </div>
</form>
