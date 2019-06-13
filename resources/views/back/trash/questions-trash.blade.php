@extends('back.master')
@section('page_title')
    <div class="title_left">
        <h3>Trashed Question List</h3>
    </div>
@endsection
@section('stylesheet')
  <link href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" rel="stylesheet">
@endsection
@section('contain')
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>All Trashed Question Question <small>List</small></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <button type="button" class="btn btn-sm btn-danger" id="permanent_delete"><i class="fa fa-trash-o"></i> Permanently Delete</button>
               <div class="table-responsive">
                   <table id="question_table" class="table table-bordered">
                       <thead>
                         <tr>
                             <th>#</th>
                             <th>Tile</th>
                             <th>Category</th>
                             <th>Tags</th>
                             <th>Status</th>
                             <th>Create Date</th>
                             <th>Action</th>
                         </tr>
                       </thead>
                       <tbody>
                          @forelse($questions as $row)
                              <tr>
                                  <td><input type="checkbox" name="ids[]" value="{{ $row->id }}"></td>
                                  <td>
                                      {{ $row->title }}
                                  </td>
                                  <td>
                                      {{ $row->category->name }}
                                  </td>
                                  <td>
                                      @foreach($row->tags as $tag)
                                          <button class="btn btn-info btn-xs"><i class="fa fa-tag"></i> {{$tag->name}}</button>
                                      @endforeach
                                  </td>
                                  <td>
                                      @if($row->status==1)
                                          <button class="btn btn-success btn-xs"><i class="fa fa-check-circle"></i> Approved</button>
                                      @else
                                          <button class="btn btn-danger btn-xs"><i class="fa fa-exclamation-circle"> Pending</i></button>
                                      @endif
                                  </td>
                                  <td>
                                      {{ $row->created_at }}
                                  </td>
                                  <td>
                                      <button class="btn btn-warning btn-xs restore_question" id="{{ $row->id }}"><i class="fa fa-refresh"></i></button>
                                  </td>
                              </tr>
                          @empty
                              <tr>
                                  <td colspan="7"> No Data Found</td>
                              </tr>
                          @endforelse
                       </tbody>
                   </table>
               </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
  <script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script>
        $('#question_table').DataTable();
        $('.restore_question').click(function () {
            var id = $(this).attr('id');
            var url = "{{url('/restore/trashed/questions')}}" + "/" + id;
            Swal.fire({
                title: 'Are you sure?',
                text: "You want to RESTORE The Question?",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, RESTORE it!'
            }).then(function (result) {
                if (result.value) {
                    $.ajax({
                        url: url,
                        type: 'GET',
                        contentType: false,
                        processData: false,
                        beforeSend: function () {
                            Swal.fire({
                                title: 'Restoring Data.......',
                                showConfirmButton: false,
                                html: '<i class="fa fa-spinner fa-spin" style="font-size:24px"></i>',
                                allowOutsideClick: false
                            });
                        },
                        success: function (response) {
                            Swal.close();
                            console.log(response);
                            if (response === "success") {
                                Swal.fire({
                                    title: 'Successfully Restored',
                                    type: 'success',
                                    confirmButtonColor: '#3085d6',
                                    confirmButtonText: 'Ok'
                                }).then(function (result) {
                                    if (result.value) {
                                        window.location.reload();
                                    }
                                });
                            }
                        },
                        error: function (error) {
                            Swal.close();
                            console.log(error);
                        }
                    })
                }
            });
        });
        $("#permanent_delete").click(function () {
            var ids = [];
            $.each($("input[name='ids[]']:checked"),function () {
                ids.push($(this).val());
            });
            if (ids.length !== 0){
                var url = "{{ url('permanently/delete/questions') }}";
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You want to Permanently Delete?",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, Delete'
                }).then(function(result) {
                    if (result.value) {
                        $.ajax({
                            url: url,
                            type: 'POST',
                            data: {"ids": ids, "_token": "{{ csrf_token() }}"},
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
                                        title: 'Permanently Deleted',
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
            } else{
                Swal.fire(
                    'Error',
                    'Select Item First!',
                    'error'
                )
            }
        })
    </script>
@endsection
