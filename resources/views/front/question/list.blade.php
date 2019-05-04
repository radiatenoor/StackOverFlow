@extends('front.master')
@section('page_title')
    <div class="title_left">
        <h3>Question List</h3>
    </div>
@endsection
@section('stylesheet')
  <link href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" rel="stylesheet">
@endsection
@section('contain')
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Question <small>List</small></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
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
                   </table>
               </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
  <script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready( function () {
            $('#question_table').DataTable({
                processing:true,
                serverSide:true,
                ajax:"{{url('question/datatable')}}",
                columns:[
                    { data: 'hash', name: 'hash' },
                    { data: 'title', name: 'title' },
                    { data: 'category.name', name: 'category.name' },
                    { data: 'tags', name: 'tags' },
                    { data: 'status', name: 'status' },
                    { data: 'created_at', name: 'created_at' },
                    { data: 'action', name: 'action' }
                ],
                "rowCallback": function( row, data ) {
                    if ( data.hash !== null ) {
                        $('td:eq(0)', row).html( '<input type="checkbox" id="qst_id_'+data.hash+'">' );
                    }
                }
            });
        } );
    </script>
@endsection
