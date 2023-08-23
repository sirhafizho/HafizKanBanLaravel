<!-- Modal -->
<form method="POST" action="{{ route('workspaces.store') }}">
    @csrf
    <div class="modal fade" id="createWorkspaceModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content bg-dark">
                <div class="modal-header">
                    <h5 class="modal-title text-white" id="modalCenterTitle">Create Workspace</h5>
                    <button type="button" class="btn-close bg-dark" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col mb-3">
                            <label for="workspaceName" class="form-label text-white">Workspace Name</label>
                            <input type="text" id="workspaceName" name="name"
                                class="form-control bg-dark text-white" placeholder="Enter Workspace Name" />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>
                    </div>
                    <div class="row g-2">
                        <div class="col mb-0">
                            <label for="workspaceDescription" class="form-label text-white">Workspace Description
                                (optional)</label>
                            <textarea id="workspaceDescription" name="description" class="form-control bg-dark text-white"
                                placeholder="Enter Workspace Description" rows="4" cols="50"></textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        Close
                    </button>
                    <button type="submit" class="btn btn-primary">Create Workspace</button>
                </div>
            </div>
        </div>
    </div>
</form>
