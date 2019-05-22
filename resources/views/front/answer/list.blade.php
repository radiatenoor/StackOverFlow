@extends('front.master')
@section('page_title')
    <div class="title_left">
        <h3>Answered List</h3>
    </div>
@endsection
@section('stylesheet')
    <link href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@8.10.0/dist/sweetalert2.css" rel="stylesheet">
@endsection
@section('contain')
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Answered <small>List</small></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="table-responsive">
                    <table id="question_table" class="table table-bordered">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Question</th>
                            <th>Answer</th>
                            <th>Answered Date</th>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8.10.0/dist/sweetalert2.js"></script>

    <script>
        $(document).ready( function () {
            $('#question_table').DataTable({
                processing:true,
                serverSide:true,
                ajax:"{{url('get/answered/datatable')}}",
                columns:[
                    { data: 'hash', name: 'hash' },
                    { data: 'title', name: 'title' },
                    { data: 'answer', name: 'answer' },
                    { data: 'date', name: 'date' },
                    { data: 'action', name: 'action' }
                ],
                "rowCallback": function( row, data ) {
                    if ( data.hash !== null ) {
                        $('td:eq(0)', row).html( '<input type="checkbox" id="qst_id_'+data.hash+'">' );
                    }
                }
            });
        } );
        function deletes(id){
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
                    var url = "{{url('/delete/answer')}}"+"/"+id;
                    $.ajax({
                        url:url,
                        type:'GET',
                        contentType:false,
                        processData:false,
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
        }
    </script>
@endsection
