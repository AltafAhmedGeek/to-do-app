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

                            <h4 class="text-center my-3 pb-3">PHP - Simple To Do List App</h4>

                            <div class="row row-cols-lg-auto g-3 justify-content-center align-items-center mb-4 pb-2">
                                <div class="col-12">
                                    <div data-mdb-input-init class="div-outline">
                                        <input type="text" id="name" name="name" class="form-control"
                                            placeholder="Enter task" />
                                    </div>
                                </div>

                                <div class="col-12">
                                    <button type="submit" id='save' data-mdb-button-init data-mdb-ripple-init
                                        class="btn btn-primary">Save</button>
                                </div>

                                <div class="col-12">
                                    <button type="submit" id='get_task' data-mdb-button-init data-mdb-ripple-init
                                        class="btn btn-warning">Get tasks</button>
                                </div>
                            </div>

                            <table class="table mb-4">
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
                                                    <button type="submit" id='completeBtn' data-mdb-button-init
                                                        data-mdb-ripple-init
                                                        class="btn btn-success ms-1">Finish</button>
                                                @endif
                                                <button type="submit" data-mdb-button-init data-mdb-ripple-init
                                                    class="btn btn-danger">Delete</button>
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
            $("#completeBtn").click(function() {
                $.ajax({
                    type: 'POST',
                    data:{id:},
                    url: "{{ route('post.delete') }}",
                    success: function(response) {
                        console.log(respose)
                    }
                });
                $(this).fadeOut();
            });
        });
    </script>
</body>

</html>
