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
                <h2>Admin User <small>List</small></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="table-responsive">
                    <table id="admins_table" class="table table-bordered">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
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
        $('#admins_table').DataTable({
            processing:true,
            serverSide:true,
            ajax:"{{url('render/users/datatable')}}",
            columns:[
                { data: 'hash', name: 'hash' },
                { data: 'name', name: 'name' },
                { data: 'email', name: 'email' },
                { data: 'user_role.role.role_name', name: 'user_role.role.role_name' },
                { data: 'active', name: 'active' },
                { data: 'created_at', name: 'created_at' },
                { data: 'action', name: 'action' }
            ]
        })
    </script>
@endsection