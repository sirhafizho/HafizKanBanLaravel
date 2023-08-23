<form method="POST" action="{{ route('workspaces.destroy', $workspace) }}" class="d-inline">
    @csrf
    @method('DELETE')
    <div class="modal fade" id="deleteWorkspaceModal{{ $workspace->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content bg-dark">
                <div class="modal-header">
                    <h5 class="modal-title text-white" id="modalCenterTitle">Delete Workspace - {{ $workspace->name }}
                    </h5>
                    <button type="button" class="btn-close bg-dark" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h3 style="color: #ff3e1d;font-weight:bold">Are you sure you want to delete this workspace?</h3>
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
