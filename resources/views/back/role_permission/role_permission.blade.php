@extends('back.master')
@section('page_title')
    <div class="title_left">
        <h3>Roles | Permissions</h3>
    </div>
@endsection
@section('stylesheet')
    <link href="{{ asset('js/admin/select2/dist/css/select2.css') }}" rel="stylesheet">
@endsection
@section('contain')
    <div class="col-md-6">
        <div class="x_panel">
            <div class="x_title">
                <h2>Roles</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="table-responsive">
                    <table id="question_table" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Slug</th>
                                <th>Role Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                          @foreach($roles as $role)
                            <tr>
                              <td>{{$role->id}}</td>
                              <td>{{$role->slug}}</td>
                              <td>{{$role->role_name}}</td>
                              <td>
                                  <button class="btn btn-info btn-xs"><i class="fa fa-edit"></i></button>
                                  <button class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></button>
                              </td>
                            </tr>
                          @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="x_panel">
            <div class="x_title">
                <h2>Permissions</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="table-responsive">
                    <table id="question_table" class="table table-bordered">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Slug</th>
                            <th>Permission Name</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($permissions as $permission)
                            <tr>
                                <td>{{$permission->id}}</td>
                                <td>{{$permission->slug}}</td>
                                <td>{{$permission->permission_name}}</td>
                                <td>
                                    <button class="btn btn-info btn-xs"><i class="fa fa-edit"></i></button>
                                    <button class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Assigned Permissions To Role</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <button class="btn btn-success btn-sm" data-toggle="modal" data-target=".role_permission_modal"><i class="fa fa-plus-square-o"></i> Assign</button>
                <div class="table-responsive">
                    <table id="question_table" class="table table-bordered">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Role</th>
                            <th>Permissions</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($roles as $role)
                            <tr>
                                <td>{{$role->id}}</td>
                                <td>{{$role->role_name}}</td>
                                <td>
                                    @forelse($role->permissions as $role_permission)
                                        <button class="btn btn-success btn-xs">
                                            {{$role_permission->permission_name}}
                                        </button>
                                    @empty
                                        <button class="btn btn-danger btn-xs">
                                            No Permission Assigned
                                        </button>
                                    @endforelse
                                </td>
                                <td>
                                    <button id="{{$role->id}}" data-permissions="{{$role->permissions->pluck('id')}}" class="btn btn-info btn-xs edit_modal">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                    <button id="{{$role->id}}" class="btn btn-danger btn-xs delete_role_permission"><i class="fa fa-trash"></i></button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- Assign modal -->
           <div class="modal fade role_permission_modal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">

                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                        </button>
                        <h4 class="modal-title" id="modal-title">Assigned Permission To A Role</h4>
                    </div>
                    <form id="role_permission_form" class="form-horizontal" data-parsley-validate="" action="{{route('assign.role.permission')}}" method="post">
                        <div class="modal-body">
                             @csrf
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Role <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <select class="form-control" name="role" id="role">
                                        <option value="">-- Select Role --</option>
                                        @foreach($roles as $role)
                                            <option value="{{$role->id}}">{{$role->role_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Permission <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <select class="form-control" name="permission[]" id="permission" multiple>
                                        <option value="">-- Select Permission --</option>
                                        @foreach($permissions as $permission)
                                            <option value="{{$permission->id}}">{{$permission->permission_name}}</option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>
                         </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
                            <button type="submit" id="assign-permission" class="btn btn-success"><i class="fa fa-save"></i> Assign</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- / Assign modal -->

    </div>
@endsection
@section('script')
    <script src="{{ asset('js/admin/select2/dist/js/select2.js') }}"></script>
    <script>
       $("#permission").select2();
       $(".edit_modal").click(function () {
           var permission = JSON.parse($(this).attr('data-permissions'));
           var url = "{{url('update/role/permission')}}";
           var id = $(this).attr('id');

           $("#role_permission_form").attr('action',url+"/"+id);
           $('#modal-title').html('Edit Assigned Permission');
           $('#assign-permission').html('Update');
           $(".role_permission_modal").modal();
           $("#role").val(id);
           /*Set values in select 2*/
           $('#permission').val(permission);
           $('#permission').select2().trigger('change');
       });
       $(".delete_role_permission").click(function () {
           var id = $(this).attr('id');
       })
    </script>
@endsection