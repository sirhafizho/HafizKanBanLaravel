<!-- Modal -->
<form method="POST" action="{{ route('tasklists.update', ['workspace' => $workspace, 'taskList' => $taskList]) }}">
    @csrf
    @method('PATCH')
    <div class="modal fade" id="editTaskListModal{{ $taskList->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content bg-dark">
                <div class="modal-header">
                    <h5 class="modal-title text-white" id="modalCenterTitle">Edit Task List</h5>
                    <button type="button" class="btn-close bg-dark" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col mb-3">
                            <label for="editTaskListTitle" class="form-label text-white">Task List Title</label>
                            <input required type="text" id="editTaskListTitle" name="title"
                                class="form-control bg-dark text-white" placeholder="Enter Task List Title"
                                value="{{ old('title', $taskList->title) }}" />
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
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
