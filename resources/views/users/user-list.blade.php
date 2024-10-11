@extends('layouts.app')
@section('content')
    <html>
    <head>
        <!-- Font Awesome -->
        <link rel="stylesheet" href="{{asset('custom/font-awesome-4.7.0/css/font-awesome.min.css')}}">
        <link rel="stylesheet" href="{{asset('plugins/fontawesome-free/css/all.min.css')}}">
        <!-- Theme style -->
        <link rel="stylesheet" href="{{asset('dist/css/adminlte.min.css')}}">
        <script src="{{asset('plugins/jquery/jquery.min.js')}}"></script>
        <!-- Bootstrap 4 -->
        <script src=" {{asset('plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
        <link rel="stylesheet" type="text/css" href="{{asset('plugins/DataTables/datatables.min.css')}}"/>
        <script type="text/javascript" src="{{asset('plugins/DataTables/datatables.min.js')}}"></script>
        <script type="text/javascript" src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.3.1/js/buttons.html5.min.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.print.min.js"></script>
        <link rel="stylesheet" href="front_assets/css/custom.css">
        <!-- SweetAlert CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

        <!-- SweetAlert JS -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <meta name="csrf-token" content="{{ csrf_token() }}">

    </head>
    <body>

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-primary card-outline">
                    <div class="card-body">
                        <button class="btn btn-primary" id="edit-btn" onclick="addNewUser()">Add New User</button>
                        <div class="col-12">
                            <div class="row">
                                <div class="col-lg-12">
                                    <br>
                                    <div class="card-body">
                                        <section class="content">
                                            <table id="users_table" class="table table-striped table-bordered"
                                                   style="width:100% ">
                                                <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Email</th>
                                                    <th>Date</th>
                                                    <th>Action</th>
                                                </tr>
                                                </thead>
                                            </table>
                                        </section>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="details" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title white-color">User Details</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <table class="table table-sm">
                                        <tbody>
                                        <tr>
                                            <td><b>Name</b></td>
                                            <td><input type="text" class="form-control name"></td>
                                        </tr>
                                        <tr>
                                            <td><b>Email</b></td>
                                            <td><input type="text" class="form-control email"></td>
                                        </tr>
                                        <tr>
                                            <td><b>Image</b></td>
                                            <td>
                                                <img class="user-image img-fluid" alt="User Image" style="max-width: 100px;" />
                                                <input type="file" class="form-control image-input mt-2" accept="image/*">
                                            </td>
                                        </tr>
                                        <input type="hidden" class="form-control id">
                                        </tbody>
                                    </table>
                                </div>
                                <button class="btn btn-primary" id="edit-btn" onclick="saveUserDetails()">Update</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="createUserModal" tabindex="-1" role="dialog" aria-labelledby="createUserModalLabel">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createUserModalLabel">Create New User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="createUserForm" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="userName" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="userEmail" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="userPassword" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="mb-3">
                            <label for="userImage" class="form-label">Profile Image</label>
                            <input type="file" class="form-control" id="userImage" name="userImage" accept="image/*">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="submitUserButton">Create User</button>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript" language="javascript">
        $(document).ready(function () {
            $('#users_table').DataTable({
                buttons: {
                    dom: {
                        button: {
                            className: 'btn btn-outline-info ml-2 mb-4'
                        }
                    },
                    buttons: [
                        {
                            extend: 'excel',
                            text: '<i class="fa fa-file-excel-o"></i>',
                            titleAttr: 'Export Excel',
                            filename: 'users_list'
                        },
                        {
                            extend: 'csvHtml5',
                            text: '<i class="fa fa-file-csv"></i>',
                            titleAttr: 'Export CSV',
                            filename: 'users_list'
                        },
                        {
                            extend: 'pdfHtml5',
                            text: '<i class="fa fa-file-pdf-o"></i>',
                            titleAttr: 'Export PDF',
                            orientation: 'landscape',
                            pageSize: 'LEGAL',
                            filename: 'users_list'
                        },
                        {extend: 'print', text: '<i class="fa fa-print"></i>', titleAttr: 'Print', title: 'users_list'},
                        {
                            extend: 'copyHtml5',
                            text: '<i class="fa fa-files-o"></i>',
                            titleAttr: 'Copy Data to Clipboard'
                        }
                    ],
                },
                language: {
                    searchPlaceholder: "Search In Table Data",
                    search: "",
                },
                searching: true,
                pageLength: 25,
                order: [[2, 'desc']],  // Change to index 2 for the "created_at" column
                columnDefs: [],
                ajax: {
                    url: "{{url('user_list')}}",
                    type: "GET",
                },
                processing: true,
                dom: '<"toolbar">RlBfrtip',
                initComplete: function () {
                    $("#users_table").wrap("<div style='overflow-x:auto; width:100%;'></div>");
                },
                columns: [
                    {data: "name"},
                    {data: "email"},
                    {data: "created_at"},
                    {
                        data: null,
                        render: function (data, type, row) {
                            var id = row.id;
                            let cell_content2 = null;
                            let cell_content3 = null;

                            cell_content2 = '<a class="btn btn-secondary btn-md" onclick="view_details(' + id + ')" href="#"> <i class="fas fa-eye" title="Click to View User Details"></i></a>';
                            cell_content3 = '<a class="btn btn-danger btn-md" onclick="delete_user(' + id + ')" href="#"> <i class="fas fa-trash" title="Click to Delete User"></i></a>';

                            return cell_content2 + cell_content3; // Correct concatenation
                        }
                    }

                ],
            });
        });
    </script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

            function delete_user(id) {
            // Use SweetAlert for confirmation
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // If the user confirms, send the AJAX request
                    $.ajax({
                        type: "post",
                        url: "<?= URL::to('/soft_delete_user'); ?>",
                        data: {
                            "_token": "<?= csrf_token(); ?>", // Ensure CSRF token is included
                            "id": id
                        },
                        success: function (response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                text: response.message,
                                showConfirmButton: false,
                                timer: 2000 // Show for 2 seconds
                            });
                            setTimeout(function () {
                                location.reload();
                            }, 2000);
                        },
                        error: function (xhr, status, error) {
                            Swal.fire(
                                'Error!',
                                'An error occurred while deleting the user.',
                                'error'
                            );
                            console.error("Error deleting user: ", error);
                        }
                    });
                }
            });
        }


        function view_details(id) {
            $('#details').modal('show');
            $.ajax({
                type: "post",
                url: "<?= URL::to('/user_details'); ?>/",
                data: { "id": id },
                success: function (data) {
                    console.log(data);
                    $('.name').val(data.name);
                    $('.email').val(data.email);
                    $('.id').val(data.id);
                    // Set image src
                    if (data.image) {
                        $('.user-image').attr('src', window.location.origin + data.image);
                    } else {
                        $('.user-image').attr('src', '<?= URL::to('/images/default_user.png'); ?>'); // default image
                    }
                },
                error: function (xhr, status, error) {
                    console.error("Error fetching user details: ", error);
                }
            });
        }
        function saveUserDetails() {
            // Use FormData to handle file upload
            let formData = new FormData();
            formData.append('name', $('.name').val());
            formData.append('email', $('.email').val());
            formData.append('id', $('.id').val());

            // Check if a new image is uploaded
            const imageFile = $('.image-input')[0].files[0];
            if (imageFile) {
                formData.append('image', imageFile);
            }

            $.ajax({
                type: "post",
                url: "<?= URL::to('/update_user'); ?>/",
                data: formData,
                processData: false, // Important for file upload
                contentType: false, // Important for file upload
                success: function (response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: response.message,
                        showConfirmButton: false,
                        timer: 2000 // Show for 2 seconds
                    });
                    $('#details').modal('hide');
                },
                error: function (xhr, status, error) {
                    const errorMessage = xhr.responseJSON?.error || 'An error occurred';
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: errorMessage,
                        confirmButtonText: 'OK'
                    });
                }
            });
        }
        function addNewUser() {
            $('#createUserModal').modal('show');
        }
        $(document).ready(function () {
            $('#submitUserButton').click(function (e) {
                e.preventDefault();
                var formData = new FormData(document.getElementById('createUserForm'));
                $.ajax({
                    url: '/create_user', // Your Laravel route
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: response.message,
                            showConfirmButton: false,
                            timer: 2000 // Show for 2 seconds
                        });
                        $('#createUserModal').modal('hide'); // Close the modal
                        setTimeout(function () {
                            location.reload();
                        }, 2000);
                    },
                    error: function (xhr, status, error) {
                        // Parse the error response if available
                        const errorMessage = xhr.responseJSON?.error || 'An error occurred';
                        // Show an error alert with SweetAlert
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: errorMessage,
                            confirmButtonText: 'OK'
                        });
                    }
                });
            });
        });
    </script>
    <script src="front_assets/js/custom.js"></script>
    </body>
    </html>
@endsection
