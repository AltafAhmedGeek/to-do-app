<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('bootstrap.min.css') }}" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>To-Do</title>
</head>

<body>
    <section class="vh-100" style="background-color: #eee;">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col col-lg-9 col-xl-7">
                    <div class="card rounded-3">
                        <div class="card-body p-4">
                            <div id="alertContainer">

                            </div>
                            <h4 class="text-center my-3 pb-3">PHP - Simple To Do List App</h4>

                            <div class="row row-cols-lg-auto g-3 justify-content-center align-items-center mb-4 pb-2">
                                <div class="col-12">
                                    <div data-mdb-input-init class="div-outline">
                                        <input type="text" id="name" name="name" class="form-control"
                                            placeholder="Enter task" />
                                    </div>
                                </div>

                                <div class="col-12">
                                    <button type="submit" id='saveTaskBtn' data-mdb-button-init data-mdb-ripple-init
                                        class="btn btn-primary">Save</button>
                                </div>
                            </div>

                            <table id='taskTableBody' class="table mb-4">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Task</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($tasks as $task)
                                        <tr>
                                            <th scope="row">1</th>
                                            <td>{{ $task->name }}</td>
                                            <td>{{ $task->status }}</td>
                                            <td>
                                                @if ($task->status !== 'Done')
                                                    <button data-id="{{ $task->id }}" data-mdb-ripple-init
                                                        class="completeBtn btn btn-success ms-1">Complete</button>
                                                @endif
                                                <button data-id="{{ $task->id }}" data-mdb-button-init
                                                    data-mdb-ripple-init
                                                    class="btn btn-danger deleteBtn">Remove</button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="{{ asset('bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('jquery-3.7.1.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            function saveTask() {
                var taskName = $("#name").val();
                $.ajax({
                    type: 'POST',
                    url: "{{ route('task.store') }}",
                    data: {
                        name: taskName
                    },
                    success: function(response) {
                        if (response.status) {
                            var newTask = response.task;
                            var newRow = '<tr>' +
                                '<th scope="row">' + newTask.id + '</th>' +
                                '<td>' + newTask.name + '</td>' +
                                '<td>' + newTask.status + '</td>' +
                                '<td>' +
                                '<button type="button" data-id="' + newTask.id +
                                '" class="btn btn-success completeBtn">Complete</button>' +
                                '<button type="button" data-id="' + newTask.id +
                                '"class="btn btn-danger deleteBtn">Remove</button>' +
                                '</td>' +
                                '</tr>';
                            $("#taskTableBody").append(
                                newRow);
                        } else {
                            var errors = response.errors;
                            var errorMessage = '<ul>';
                            for (var key in errors) {
                                errorMessage += '<li>' + errors[key][0] + '</li>';
                            }
                            errorMessage += '</ul>';
                            $('#alertContainer').html('<div class="alert alert-danger">' +
                                errorMessage + '</div>');
                        }
                    },
                    error: function(xhr, status, error) {
                        $('#alertContainer').html('<div class="alert alert-danger">' +
                            xhr.responseJSON.message + '</div>');
                    }
                });
            }
            $("#saveTaskBtn").click(saveTask);
            $("#name").keydown(function(event) {
                if (event.keyCode === 13) {
                    event.preventDefault();
                    saveTask();
                }
            });

            $(document).on('click', '.completeBtn', function() {
                var taskId = $(this).data('id');
                var button = $(this);

                $.ajax({
                    type: 'POST',
                    url: "{{ route('task.complete') }}",
                    data: {
                        id: taskId
                    },
                    success: function(response) {
                        if (response.success) {
                            button.hide();
                            button.parent().prev().text('Done');
                        } else {
                            alert('Failed to complete task.');
                        }
                    },
                    error: function(xhr, status, error) {
                        $('#alertContainer').html('<div class="alert alert-danger">' +
                            xhr.responseJSON.message + '</div>');
                    }
                });
            });
            $(document).on('click', '.deleteBtn', function() {
                var taskId = $(this).data('id');
                var row = $(this).closest('tr');

                if (confirm('Are you sure you want to delete this task?')) {
                    $.ajax({
                        type: 'POST',
                        url: "{{ route('task.delete') }}",
                        data: {
                            id: taskId
                        },
                        success: function(response) {
                            if (response.success) {
                                row.remove();
                            } else {
                                alert('Failed to delete task.');
                            }
                        },
                        error: function(xhr, status, error) {
                            $('#alertContainer').html('<div class="alert alert-danger">' +
                                xhr.responseJSON.message + '</div>');
                        }
                    });
                }
            });
        });
    </script>
</body>

</html>
