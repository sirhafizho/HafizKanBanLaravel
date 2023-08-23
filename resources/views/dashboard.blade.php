<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    {{-- <section class="max-w-7xl mx-auto">
        <div class="container-sm" style="padding-top: 3rem">
            <div class="dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </section> --}}

    

    <section class="max-w-7xl mx-auto mt-4">
        <div class="container flex-grow-1 container-p-y">
            {{-- Profile Card --}}
            <div class="row">
                <div class="col mb-4 order-0">
                    <div class="card bg-gray-800 text-gray-100 px-3">
                        <div class="d-flex align-items-center row">
                            <div class="col-sm-7">
                                <div class="card-body">
                                    <h5 class="card-title text-white h3">Welcome <span
                                            class="text-primary">{{ Auth::user()->name }}</span>!🎉</h5>
                                    {{-- <p class="mb-4">
                                        You have done <span class="fw-bold">72%</span> more sales today. Check your new
                                        badge in
                                        your profile.
                                    </p> --}}

                                    {{-- <a href="javascript:;" class="btn btn-sm btn-outline-primary">View Badges</a> --}}
                                </div>
                            </div>
                            <div class="col-sm-5">
                                <div class="card-body pb-0 d-flex justify-content-end me-3">
                                    <img src="{{ asset('assets/img/illustrations/man-with-laptop-light.png') }}"
                                        style="height: 200px" alt="View Badge User"
                                        data-app-dark-img="illustrations/man-with-laptop-dark.png"
                                        data-app-light-img="illustrations/man-with-laptop-light.png" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col mb-4 order-1">
                    <div class="card dark:bg-gray-800 dark:text-gray-100 pt-4 pb-2 px-3">
                        <h5 class="card-header text-white h5 fw-bold border border-0">Your Workspaces</h5>
                        <div class="card-body">
                            <div class="row">
                                <div class="col d-flex justify-content-center">
                                    <button class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#createWorkspaceModal">
                                        Create A New Workspace
                                    </button>
                                </div>
                            </div>
                            @if (!$workspaces->isEmpty())
                                <div class="row mt-5 justify-content-center align-items-center">
                                    @foreach ($workspaces as $workspace)
                                        <div class="col-md-4 mb-4">
                                            <div class="card bg-dark text-center d-flex flex-column h-100">
                                                <div class="card-header fw-bold h3 text-white">
                                                    {{ $workspace->name }}
                                                </div>
                                                {{-- <div class="card-body flex-grow-1 h-100">
                                                    <p class="card-text">{{ $workspace->description }}</p>
                                                </div> --}}
                                                <div class="card-footer text-muted">
                                                    <div>
                                                        <a href="{{ route('workspace.show', ['id' => $workspace->id]) }}"
                                                            class="btn btn-primary mb-2">View
                                                            Workspace</a>
                                                    </div>
                                                    <div>
                                                        <a href="#" class="btn btn-info" data-bs-toggle="modal"
                                                            data-bs-target="#editWorkspaceModal{{ $workspace->id }}">Edit
                                                            Workspace</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    

    @include('components.workspaces.modal-create-workspace')
    @foreach ($workspaces as $workspace)
        @include('components.workspaces.modal-update-workspace', [
            'workspace' => $workspace,
        ])
        @include('components.workspaces.modal-delete-workspace', [
            'workspace' => $workspace,
        ])
    @endforeach

    <script>
        // Add an event listener for each "Edit Workspace" button
        document.addEventListener('DOMContentLoaded', function() {
            const editWorkspaceButtons = document.querySelectorAll('.edit-workspace-button');

            editWorkspaceButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const workspaceId = button.getAttribute('data-workspace-id');
                    const modalId = `editWorkspaceModal${workspaceId}`;
                    const modal = new bootstrap.Modal(document.getElementById(modalId));
                    modal.show();
                });
            });
        });
    </script>




</x-app-layout>
