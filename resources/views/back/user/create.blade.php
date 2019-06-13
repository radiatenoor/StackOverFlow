@extends('back.master')
@section('page_title')
    <div class="title_left">
        <h3>User Create</h3>
    </div>
@endsection
@section('stylesheet')

@endsection
@section('contain')
  <div class="col-md-12 col-sm-12 col-xs-12">
     <div class="x_panel">
        <div class="x_title">
            <h2>New User Entry</h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <br>
            <form id="question_form" action="{{route('store.user')}}" method="post"
                  data-parsley-validate="" class="form-horizontal form-label-left"
                  enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">User Info
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">

                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Name <span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" id="name" name="name"
                               class="form-control col-md-7 col-xs-12" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Email <span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" id="email" name="email"
                               class="form-control col-md-7 col-xs-12" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Password <span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="password" id="password" name="password"
                               class="form-control col-md-7 col-xs-12" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Confirm Password <span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="password" id="password_confirmation" name="password_confirmation"
                               class="form-control col-md-7 col-xs-12" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Photo <span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="file" id="photo" name="photo"
                               class="form-control col-md-7 col-xs-12" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Photo Preview <span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <img src="" id="photo_preview" name="photo_preview" style="width: 150px;height: 150px">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Assign Role
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">

                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Role <span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <select class="form-control" name="role">
                            <option value="">-- Select Role --</option>
                            @foreach($roles as $role)
                                <option value="{{$role->id}}">{{$role->role_name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="ln_solid"></div>
                <div class="form-group">
                    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                        <button class="btn btn-primary" type="reset">Reset</button>
                        <button type="submit" class="btn btn-success" value="validate">Submit</button>
                    </div>
                </div>

            </form>
        </div>
        </div>
  </div>
@endsection
@section('script')
    <script>
        function readURL(input) {

            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#photo_preview').attr('src', e.target.result);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#photo").change(function() {
            readURL(this);
        });
    </script>
@endsection