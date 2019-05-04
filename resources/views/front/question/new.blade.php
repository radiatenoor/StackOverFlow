@extends('front.master')
@section('page_title')
    <div class="title_left">
        <h3>New Question</h3>
    </div>
@endsection
@section('stylesheet')
    <link href="{{ asset('js/admin/select2/dist/css/select2.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@8.10.0/dist/sweetalert2.css" rel="stylesheet">
@endsection
@section('contain')
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>New Question Entry</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <br>
                    <form id="question_form" action="{{ route('store.question') }}" method="post" data-parsley-validate="" class="form-horizontal form-label-left">
                        @csrf
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Title <span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" id="title" name="title"
                                       data-parsley-trigger="keyup"
                                       data-parsley-minlength="6"
                                       data-parsley-maxlength="100"
                                       data-parsley-minlength-message="Come on! You need to enter at least a 6 character comment.."
                                       class="form-control col-md-7 col-xs-12" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Category <span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <select name="category" class="form-control col-md-7 col-xs-12" required>
                                    <option value="">-- Selecte Category --</option>
                                    <!-- category loop -->
                                    @foreach($categories as $category)
                                      <option value="{{$category->id}}">{{$category->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Tag <span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <select name="tag[]" id="tag" class="form-control col-md-7 col-xs-12" required multiple>
                                    <!-- Tag loop -->
                                    @foreach($tags as $tag)
                                       <option value="{{$tag->id}}">{{ $tag->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Description <span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                               <textarea name="description" id="description" required></textarea>
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
    </div>
@endsection
@section('script')
 <script src="{{ asset('js/admin/select2/dist/js/select2.js') }}"></script>
 <script src="{{ asset('js/admin/parsleyjs/dist/parsley.js') }}"></script>
 <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8.10.0/dist/sweetalert2.js"></script>
 <script>
     $(function () {
        $("#tag").select2();
        $("#question_form").on('submit',function (e) {
            var form = $(this);
            form.parsley().validate();
            if (form.parsley().isValid()){
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then(function(result) {
                    if (result.value) {
                        var form = $("#question_form")[0];
                        var form_data = new FormData(form);
                        $.ajax({
                            url:"{{route('store.question')}}",
                            data:form_data,
                            type:"POST",
                            contentType:false,
                            processData:false,
                            beforeSend:function(){
                                Swal.fire({
                                    title: 'Sending Data.......',
                                    showConfirmButton: false,
                                    html: '<i class="fa fa-spinner fa-spin" style="font-size:24px"></i>',
                                    allowOutsideClick: false
                                });
                            },
                            success:function (data) {
                                Swal.close();
                                console.log(data);
                            },
                            error:function (error) {
                                Swal.close();
                                console.log(data);
                            }
                        });
                    }
                });
            }
            e.preventDefault();
        });
     });
//     $(document).ready(function() {
//
//     });
 </script>
@endsection
