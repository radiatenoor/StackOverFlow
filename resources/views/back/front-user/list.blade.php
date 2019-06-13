@extends('back.master')
@section('page_title')
    <div class="title_left">
        <h3>User List</h3>
    </div>
@endsection
@section('stylesheet')
    <link href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" rel="stylesheet">
@endsection
@section('contain')
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>All User <small>List</small></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <button class="btn btn-danger btn-sm" id="delete_all"><i class="fa fa-trash"></i> Delete</button>
                <button class="btn btn-success btn-sm" id="active_all"><i class="fa fa-check"></i> Activate?</button>
                <button class="btn btn-warning btn-sm" id="deactivate_all"><i class="fa fa-exclamation-circle"></i> Deactivate?</button>
                <div class="table-responsive">
                    <table id="users_table" class="table table-bordered">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>location</th>
                            <th>Active</th>
                            <th>Create Date</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script>
        $('#users_table').DataTable({
            processing:true,
            serverSide:true,
            ajax:"{{url('render/question/user/datatable')}}",
            columns:[
                { data: 'hash', name: 'hash' },
                { data: 'name', name: 'name' },
                { data: 'email', name: 'email' },
                { data: 'location', name: 'location' },
                { data: 'active', name: 'active' },
                { data: 'created_at', name: 'created_at' },
                { data: 'action', name: 'action' }
            ]
        });
        $(function () {
            // delete all selected user id
            $('#delete_all').click(function () {
                var ids = [];
                // get all selected user id
                $.each($("input[name='user_ids[]']:checked"), function(){
                    ids.push($(this).val());
                });
                if (ids.length!==0) {
                    var url = "{{ url('delete/all/users') }}";
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You want to delete?",
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, Delete it!'
                    }).then(function(result) {
                        if (result.value) {
                            $.ajax({
                                url: url,
                                type: 'POST',
                                data: {"user_ids": ids, "_token": "{{ csrf_token() }}"},
                                dataType: "json",
                                beforeSend:function () {
                                    Swal.fire({
                                        title: 'Deleting Data.......',
                                        showConfirmButton: false,
                                        html: '<i class="fa fa-spinner fa-spin" style="font-size:24px"></i>',
                                        allowOutsideClick: false
                                    });
                                },
                                success:function (response) {
                                    Swal.close();
                                    console.log(response);
                                    if (response==="success"){
                                        Swal.fire({
                                            title: 'Successfully Deleted',
                                            type: 'success',
                                            confirmButtonColor: '#3085d6',
                                            confirmButtonText: 'Ok'
                                        }).then(function(result) {
                                            if (result.value) {
                                                window.location.reload();
                                            }
                                        });
                                    }
                                },
                                error:function (error) {
                                    Swal.close();
                                    console.log(error);
                                }
                            })
                        }
                    });
                }else{
                    Swal.fire(
                        'Error',
                        'Select The Users First!',
                        'error'
                    )
                }
            });

            // activate all selected user id
            $('#active_all').click(function () {
                var ids = [];
                // get all selected user id
                $.each($("input[name='user_ids[]']:checked"), function(){
                    ids.push($(this).val());
                });
                if (ids.length!==0) {
                    var url = "{{ url('activate/all/users') }}";
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You want to active?",
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, Activate'
                    }).then(function(result) {
                        if (result.value) {
                            $.ajax({
                                url: url,
                                type: 'POST',
                                data: {"user_ids": ids, "_token": "{{ csrf_token() }}"},
                                dataType: "json",
                                beforeSend:function () {
                                    Swal.fire({
                                        title: 'Activating Users.......',
                                        showConfirmButton: false,
                                        html: '<i class="fa fa-spinner fa-spin" style="font-size:24px"></i>',
                                        allowOutsideClick: false
                                    });
                                },
                                success:function (response) {
                                    Swal.close();
                                    console.log(response);
                                    if (response==="success"){
                                        Swal.fire({
                                            title: 'Successfully Activated',
                                            type: 'success',
                                            confirmButtonColor: '#3085d6',
                                            confirmButtonText: 'Ok',
                                            allowOutsideClick: false
                                        }).then(function(result) {
                                            if (result.value) {
                                                window.location.reload();
                                            }
                                        });
                                    }
                                },
                                error:function (error) {
                                    Swal.close();
                                    console.log(error);
                                }
                            })
                        }
                    });
                }else{
                    Swal.fire(
                        'Error',
                        'Select The Users First!',
                        'error'
                    )
                }
            });

            // deactivate all selected users
            $('#deactivate_all').click(function () {
                var ids = [];
                // get all selected user id
                $.each($("input[name='user_ids[]']:checked"), function(){
                    ids.push($(this).val());
                });
                if (ids.length!==0) {
                    var url = "{{ url('deactivate/all/users') }}";
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You want to Deactivate?",
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, Deactivate'
                    }).then(function(result) {
                        if (result.value) {
                            $.ajax({
                                url: url,
                                type: 'POST',
                                data: {"user_ids": ids, "_token": "{{ csrf_token() }}"},
                                dataType: "json",
                                beforeSend:function () {
                                    Swal.fire({
                                        title: 'Deactivating Users.......',
                                        showConfirmButton: false,
                                        html: '<i class="fa fa-spinner fa-spin" style="font-size:24px"></i>',
                                        allowOutsideClick: false
                                    });
                                },
                                success:function (response) {
                                    Swal.close();
                                    console.log(response);
                                    if (response==="success"){
                                        Swal.fire({
                                            title: 'Successfully Deactivated',
                                            type: 'success',
                                            confirmButtonColor: '#3085d6',
                                            confirmButtonText: 'Ok',
                                            allowOutsideClick: false
                                        }).then(function(result) {
                                            if (result.value) {
                                                window.location.reload();
                                            }
                                        });
                                    }
                                },
                                error:function (error) {
                                    Swal.close();
                                    console.log(error);
                                }
                            })
                        }
                    });
                }else{
                    Swal.fire(
                        'Error',
                        'Select The Users First!',
                        'error'
                    )
                }
            });
        });
        function deleteUser(id) {
            var url = "{{ url('delete/user/') }}";
            Swal.fire({
                title: 'Are you sure?',
                text: "You want to Delete?",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Delete It!'
            }).then(function(result) {
                if (result.value) {
                    $.ajax({
                        url: url+"/"+id,
                        type: 'GET',
                        dataType: "json",
                        beforeSend:function () {
                            Swal.fire({
                                title: 'Deleting User.......',
                                showConfirmButton: false,
                                html: '<i class="fa fa-spinner fa-spin" style="font-size:24px"></i>',
                                allowOutsideClick: false
                            });
                        },
                        success:function (response) {
                            Swal.close();
                            console.log(response);
                            if (response==="success"){
                                Swal.fire({
                                    title: 'Successfully Deleted',
                                    type: 'success',
                                    confirmButtonColor: '#3085d6',
                                    confirmButtonText: 'Ok',
                                    allowOutsideClick: false
                                }).then(function(result) {
                                    if (result.value) {
                                        window.location.reload();
                                    }
                                });
                            }
                        },
                        error:function (error) {
                            Swal.close();
                            console.log(error);
                        }
                    })
                }
            });
        }
    </script>
@endsection