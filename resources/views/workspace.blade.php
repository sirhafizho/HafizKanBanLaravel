<x-sneat-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Workspace') }} / {{ $workspace->name }}
        </h2>
    </x-slot>

    <style>
        .card.draggable {
            /* margin-bottom: 1rem; */
            cursor: grab;
        }

        .droppable {
            background-color: var(--success);
            min-height: 120px;
            margin-bottom: 1rem;
        }
    </style>


    <div class="bs-toast toast fade show bg-dark" role="alert" aria-live="assertive" aria-atomic="true"
        style="position: absolute;top:5%;right:5%">
        <div class="toast-header">
            <div class="me-auto fw-medium">Alert!</div>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
            The Draggable and Move function is currently unavailable, I am still figuring it out
        </div>
    </div>



    @if ($workspace->description != '')
        <section class="container mt-5">
            <div class="row">
                <div class="col">
                    <div class="card dark:bg-gray-800">
                        <div class="card-body">
                            <p class="text-white">Description : {{ $workspace->description }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

    <section class="container-fluid flex-grow-1">
        <div class="row flex-row py-3">
            @if ($taskLists->isEmpty())
                <div class="col-sm-6 col-md-4 col-xl-3 d-flex justify-content-start">
                    <div class="card dark:bg-gray-800" style="width:100%;height: fit-content;">
                        <div class="card-body p-2">
                            <button id="showTaskListForm" class="btn btn-primary d-flex align-items-center"
                                style="width:100%">
                                <i class='bx bx-plus me-2'></i>
                                Create a new task list
                            </button>
                            <div class="mt-4" id="taskListForm" style="display: none;">
                                <form method="POST" action="{{ route('tasklists.store', $workspace) }}">
                                    @csrf
                                    <label for="title" class="text-white text-capitalize fw-bold h5">Task List
                                        Title</label>
                                    <input type="text" name="title" class="form-control bg-dark text-white">
                                    <!-- Add more input fields as needed -->
                                    <button type="submit" class="btn btn-primary mt-3"
                                        style="background-color: #696cff;">Create Task List</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                @foreach ($taskLists as $taskList)
                    <div class="col-sm-6 col-md-4 col-xl-3 mt-3">
                        <div class="card dark:bg-gray-800">
                            <div class="card-header pb-1">
                                <h6
                                    class="card-title text-truncate text-white h4 d-flex justify-content-between align-items-center">
                                    {{ $taskList->title }}
                                    <div>
                                        <button class="btn btn-dark" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class='bx bx-dots-horizontal-rounded'></i>
                                        </button>
                                        <ul class="dropdown-menu bg-dark text-white">
                                            <li><a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                    data-bs-target="#editTaskListModal{{ $taskList->id }}">Edit Task
                                                    List</a></li>
                                            <li><a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                    data-bs-target="#deleteTaskList{{ $taskList->id }}">Delete Task
                                                    List</a></li>
                                        </ul>
                                    </div>
                                </h6>
                            </div>
                            <div class="card-body p-3 pt-0">
                                <div class="items">

                                    @foreach ($taskList->tasks as $task)
                                        <!-- Calculate and Display Remaining Time -->
                                        @php
                                            $dueDate = new DateTime($task->due_date);
                                            $currentDate = new DateTime();
                                            $interval = $currentDate->diff($dueDate);
                                            
                                            $remainingTime = [];
                                            if ($interval->d > 0) {
                                                $remainingTime[] = $interval->d . ' days';
                                            }
                                            if ($interval->h > 0) {
                                                $remainingTime[] = $interval->h . ' hours';
                                            }
                                            if ($interval->i > 0) {
                                                $remainingTime[] = $interval->i . ' minutes';
                                            }
                                            
                                            $remainingTimeString = implode(', ', $remainingTime); // Separate with commas
                                            
                                            $isPastDueDate = $interval->invert === 1; // Check if past due date (invert = 1 means the due date is in the past)
                                        @endphp

                                        <div class="dropzone rounded" data-task-list-id="{{ $taskList->id }}"
                                            ondrop="drop(event)" ondragover="allowDrop(event)"
                                            ondragleave="clearDrop(event)"> &nbsp; </div>

                                        <div class="card bg-dark text-white draggable shadow-sm p-1"
                                            id="task-{{ $task->id }}" draggable="true" ondragstart="drag(event)">
                                            <div class="card-header d-flex justify-content-between pb-2">
                                                <div>
                                                    <a href="#" class="lead fw-bold me-2" data-bs-toggle="modal"
                                                        data-bs-target="#updateTaskModal{{ $task->id }}">{{ $task->title }}</a>
                                                </div>
                                                <div>
                                                    <a href="#" data-bs-toggle="modal"
                                                        data-bs-target="#updateTaskModal{{ $task->id }}"><i
                                                            class='bx bx-pencil fs-3'></i></a>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <div class="d-flex mb-2">
                                                    @if ($task->priority === 'low')
                                                        <span
                                                            class="p-2 rounded-pill bg-secondary text-capitalize me-2 fw-bold">Low
                                                            Priority</span>
                                                    @elseif ($task->priority === 'medium')
                                                        <span
                                                            class="p-2 rounded-pill bg-primary text-capitalize me-2 fw-bold">Medium
                                                            Priority</span>
                                                    @else
                                                        <span
                                                            class="p-2 rounded-pill bg-warning text-capitalize me-2 fw-bold">High
                                                            Priority</span>
                                                    @endif
                                                    @if ($task->status === 'incomplete')
                                                        <span
                                                            class="p-2 rounded-pill bg-info text-capitalize me-2 fw-bold">Incomplete</span>
                                                    @else
                                                        <span
                                                            class="p-2 rounded-pill bg-success text-capitalize me-2 fw-bold">Completed</span>
                                                    @endif
                                                </div>
                                                @if ($isPastDueDate)
                                                    @if ($task->status === 'incomplete')
                                                        <div class="bg-label-danger p-2 rounded d-flex justify-content-start align-items-center text-capitalize"
                                                            style="width: fit-content">
                                                            <i class='bx bx-time-five me-2'></i>
                                                            {{ $remainingTimeString }} ago
                                                        </div>
                                                    @else
                                                        <div class="bg-label-success p-2 rounded d-flex justify-content-start align-items-center text-capitalize"
                                                            style="width: fit-content">
                                                            <i class='bx bx-time-five me-2'></i>
                                                            Completed {{ $remainingTimeString }} ago
                                                        </div>
                                                    @endif
                                                @else
                                                    <div class="bg-label-primary p-2 rounded d-flex justify-content-start align-items-center text-capitalize"
                                                        style="width: fit-content">
                                                        <i class='bx bx-time-five me-2'></i>
                                                        {{ $remainingTimeString }} remaining
                                                    </div>
                                                @endif

                                            </div>
                                        </div>
                                    @endforeach

                                    <div class="dropzone rounded" data-task-list-id="{{ $taskList->id }}"
                                        ondrop="drop(event)" ondragover="allowDrop(event)"
                                        ondragleave="clearDrop(event)"> &nbsp; </div>

                                </div>

                                <button class="btn btn-outline-info d-flex align-items-center justify-content-center"
                                    style="width:100%" data-bs-toggle="modal"
                                    data-bs-target="#createTaskModal{{ $taskList->id }}">
                                    <i class='bx bx-plus me-2'></i>
                                </button>

                            </div>
                        </div>
                    </div>
                @endforeach
                <div class="col-sm-6 col-md-4 col-xl-3 mt-3 d-flex justify-content-start">
                    <div class="card dark:bg-gray-800" style="width:100%;height: fit-content;">
                        <div class="card-body p-2">
                            <button id="showTaskListForm" class="btn btn-primary d-flex align-items-center"
                                style="width:100%">
                                <i class='bx bx-plus me-2'></i>
                                Create a new task list
                            </button>
                            <div class="mt-4" id="taskListForm" style="display: none;">
                                <form method="POST" action="{{ route('tasklists.store', $workspace) }}">
                                    @csrf
                                    <label for="title" class="text-white text-capitalize fw-bold h5">Task List
                                        Title</label>
                                    <input type="text" name="title" class="form-control bg-dark text-white">
                                    <!-- Add more input fields as needed -->
                                    <button type="submit" class="btn btn-primary mt-3"
                                        style="background-color: #696cff;">Create Task List</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </section>

    @foreach ($taskLists as $taskList)
        @include('components.taskLists.modal-update-task-list', [
            'workspace' => $workspace,
            'taskList' => $taskList,
        ])
        @include('components.taskLists.modal-delete-task-list', [
            'workspace' => $workspace,
            'taskList' => $taskList,
        ])
        @include('components.tasks.modal-create-task', [
            'workspace' => $workspace,
            'taskList' => $taskList,
        ])
        @foreach ($taskList->tasks as $task)
            @include('components.tasks.modal-update-task', [
                'task' => $task,
                'taskList' => $taskList,
            ])
            @include('components.tasks.modal-delete-task', [
                'task' => $task,
                'taskList' => $taskList,
            ])
            @include('components.tasks.modal-move-task', [
                'task' => $task,
                'taskLists' => $taskLists,
            ])
        @endforeach
    @endforeach


    <form id="taskMovementForm" action="{{ route('move-task') }}" method="POST" style="display: none;">
        @csrf
        <input type="hidden" name="task_id" id="task_id_input">
        <input type="hidden" name="new_task_list_id" id="new_task_list_id_input">
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const showTaskListFormButton = document.getElementById('showTaskListForm');
            const taskListForm = document.getElementById('taskListForm');

            showTaskListFormButton.addEventListener('click', function() {
                taskListForm.style.display = taskListForm.style.display === 'none' ? 'block' : 'none';
            });
        });
    </script>

    <script>
        const drag = (event) => {
            event.dataTransfer.setData("text/plain", event.target.id);
        }

        const allowDrop = (ev) => {
            ev.preventDefault();
            if (hasClass(ev.target, "dropzone")) {
                addClass(ev.target, "droppable");
            }
        }

        const clearDrop = (ev) => {
            removeClass(ev.target, "droppable");
        }

        const drop = (event) => {
            event.preventDefault();
            const data = event.dataTransfer.getData("text/plain");
            const element = document.querySelector(`#task-${data}`);
            const newTaskListId = event.target.getAttribute("data-task-list-id"); // Retrieve the new task list ID

            const taskIdNumber = data.split("-")[1];

            // Populate the hidden form fields
            document.querySelector('#task_id_input').value = taskIdNumber;
            document.querySelector('#new_task_list_id_input').value = newTaskListId;

            // Submit the hidden form
            document.querySelector('#taskMovementForm').submit();

            // Send an AJAX request to move the task
            // $.ajax({
            //     url: "{{ route('move-task') }}", // Use the route name you defined in web.php
            //     method: "POST",
            //     data: {
            //         task_id: taskIdNumber,
            //         new_task_list_id: newTaskListId,
            //         _token: "{{ csrf_token() }}", // Don't forget the CSRF token
            //     },
            //     success: function(response) {
            //         console.log("Nice")
            //         // Handle the success response
            //     },
            //     error: function(error) {
            //         // Handle the error response
            //     }
            // });
            updateDropzones();

            // try {
            //     // remove the spacer content from dropzone
            //     event.target.removeChild(event.target.firstChild);
            //     // add the draggable content
            //     event.target.appendChild(element);
            //     // remove the dropzone parent
            //     unwrap(event.target);
            // } catch (error) {
            //     console.warn("can't move the item to the same place")
            // }
            // updateDropzones();
        }

        const updateDropzones = () => {
            /* after dropping, refresh the drop target areas
              so there is a dropzone after each item
              using jQuery here for simplicity */

            var dz = $(
                '<div class="dropzone rounded" ondrop="drop(event)" ondragover="allowDrop(event)" ondragleave="clearDrop(event)"> &nbsp; </div>'
            );

            // delete old dropzones
            $('.dropzone').remove();

            // insert new dropdzone after each item   
            dz.insertAfter('.card.draggable');

            // insert new dropzone in any empty swimlanes
            $(".items:not(:has(.card.draggable))").append(dz);
        };

        // helpers
        function hasClass(target, className) {
            return new RegExp('(\\s|^)' + className + '(\\s|$)').test(target.className);
        }

        function addClass(ele, cls) {
            if (!hasClass(ele, cls)) ele.className += " " + cls;
        }

        function removeClass(ele, cls) {
            if (hasClass(ele, cls)) {
                var reg = new RegExp('(\\s|^)' + cls + '(\\s|$)');
                ele.className = ele.className.replace(reg, ' ');
            }
        }

        function unwrap(node) {
            node.replaceWith(...node.childNodes);
        }
    </script>




</x-sneat-layout>
