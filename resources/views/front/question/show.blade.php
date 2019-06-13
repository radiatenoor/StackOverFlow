@extends('front.master')
@section('page_title')
    <div class="title_left">
        <h3>Question</h3>
    </div>
@endsection
@section('stylesheet')

@endsection
@section('contain')
    <div class="row">
        <div class="col-md-12">
            <div class="x_panel">

                <div class="x_content">
                    <div class="row">
                        <!-- CONTENT MAIL -->
                        <div class="col-sm-9 mail_view">
                            <div class="inbox-body">
                                <div class="mail_heading row">
                                    <div class="col-md-8">
                                        <div class="btn-group">
                                            <button class="btn btn-md btn-info" type="button">Total Vote <span class="badge badge-danger">{{ isset($question->votes)?count($question->votes):0 }}</span></button>
                                            @if(!isset(Auth::user()->vote))
                                                <a href="{{route('vote',$question->id)}}" class="btn btn-md btn-default" type="button"><i class="fa fa-star-o"></i> Vote?</a>
                                            @else
                                                <button class="btn btn-md btn-success" type="button"><i class="fa fa-star"></i> Voted</button>
                                                <a href="{{route('cancel.vote',$question->id)}}" class="btn btn-md btn-danger" type="button"><i class="fa fa-exclamation-circle"></i> Cancel Vote</a>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-4 text-right">
                                        <p class="date">Asked: {{ $question->created_at }}</p>
                                    </div>
                                    <div class="col-md-12">
                                        <h4> {{ $question->title }}</h4>
                                    </div>
                                </div>
                                <div class="view-mail">
                                    <p>
                                       {{ $question->description }}
                                    </p>
                                </div>
                                <div class="attachment">
                                    <ul>
                                        @foreach($question->tags as $tag)
                                            <button class="btn btn-info btn-xs"><i class="fa fa-tag"></i> {{ $tag->name }}</button>
                                        @endforeach
                                    </ul>
                                </div>
                                <h2>All Answer <span class="badge badge-danger">{{ count($question->answers) }}</span></h2>
                                @forelse($question->answers as $answer)
                                    <div class="ln_solid"></div>
                                    <div class="view_answers">
                                        <div class="view-mail">
                                            <p>
                                                {!! $answer->answer !!}
                                            </p>
                                        </div>
                                        <div class="sender-info">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    @if(Auth::user()->id==$answer->user->id)
                                                        <span data-answer="{!! $answer->answer !!}" id="{{$answer->id}}" class="sender-dropdown edit_answer" style="cursor: pointer"><i class="fa fa-edit"></i> Edit</span>
                                                    @endif
                                                    <span id="{{$answer->id}}" class="open_comment_box" data-toggle="modal" data-target=".bs-example-modal-lg" style="cursor: pointer">
                                                        <i class="fa fa-comment"></i> Comment
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <ul class="list-unstyled msg_list">
                                            <li>
                                                <a>
                                                    <span class="image">
                                                      <img src="{{asset('images/user.png')}}" alt="img">
                                                    </span>
                                                    <span>
                                                      <span>{{$answer->user->name}}</span>
                                                    </span>
                                                    <span class="message">
                                                      Answered {{ $answer->created_at }}
                                                    </span>
                                                </a>
                                            </li>
                                        </ul>
                                        <div class="sender-info">
                                            <div class="comments">
                                                <label>Comments <span class="badge badge-danger">{{ count($answer->comments) }}</span></label>
                                                <div class="row">
                                                    @foreach($answer->comments as $comment)
                                                        <div class="col-md-10 col-md-offset-2">
                                                            <span>
                                                                <i class="fa fa-comment"></i> {{ $comment->comment }}
                                                            </span>
                                                            <span style="color: #0bff82">Comment By: {{ $comment->user->name }}</span>
                                                            @if(Auth::user()->id==$comment->user->id)
                                                              <button id="{{$comment->id}}" class="btn btn-danger btn-xs delete_comment"><i class="fa fa-trash"></i></button>
                                                            @endif
                                                            <hr>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                @empty
                                  <p>No One Answer</p>
                                @endforelse
                                <div id="answer_section">
                                    <h2>Your Answer</h2>
                                    <div class="ln_solid"></div>
                                    <form id="answer_form" data-parsley-validate="" action="{{ route('save.answer',$question->id) }}" method="post">
                                        @csrf
                                        <textarea name="answer" id="answer" rows="10" cols="80"
                                                  data-parsley-minlength="6"
                                                  data-parsley-minlength-message="Come on! You need to enter at least a 6 character comment..">

                                        </textarea>
                                        <div class="ln_solid"></div>
                                        <div class="btn-group">
                                            <button class="btn btn-sm btn-primary" type="button" id="post_answer"><i class="fa fa-save"></i> Post Answer</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!-- Comment modal -->
                            <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">

                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                                            </button>
                                            <h4 class="modal-title" id="myModalLabel">Comment Box</h4>
                                        </div>
                                        <div class="modal-body">
                                            <form id="comment_form" data-parsley-validate="" action="" method="post">
                                                @csrf
                                                <textarea name="comment" id="comment" rows="10" cols="200"
                                                          data-parsley-trigger="keyup"
                                                          data-parsley-minlength="6"
                                                          data-parsley-minlength-message="Come on! You need to enter at least a 6 character comment.."
                                                          placeholder="Comment on This Answer" style="width: 100%" required></textarea>
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
                                            <button type="button" id="save_comment" class="btn btn-success"><i class="fa fa-save"></i> Save Comment</button>
                                        </div>
                                    </div>
                                </div>
                            </div> <!-- / Comment modal -->
                        </div>
                        <!-- /CONTENT MAIL -->
                        <div class="col-sm-3 mail_list_column">
                            <a href="#">
                                <div class="mail_list">
                                    <div class="left">
                                        <i class="fa fa-circle"></i>
                                    </div>
                                    <div class="right">
                                        <h3>View <small>16 times</small></h3>
                                    </div>
                                </div>
                            </a>
                            <a href="#">
                                <div class="mail_list">
                                    <div class="left">
                                        <i class="fa fa-star"></i>
                                    </div>
                                    <div class="right">
                                        <h3>Active: <small>{{$question->status==1?'Yes':'No'}}</small></h3>
                                    </div>
                                </div>
                            </a>
                            <div class="col-xs-12 profile_details">
                                <div class="well profile_view">
                                    <div class="col-sm-12">
                                        <h4 class="brief"><i>Asked By</i></h4>
                                        <div class="right col-xs-8 col-xs-offset-2 text-center">
                                            <img src="{{asset('images/user.png')}}" alt="" class="img-circle img-responsive">
                                        </div>
                                        <div class="left col-xs-12">
                                            <h5>{{$question->user->name}}</h5>
                                            <p><strong>About: </strong> {{$question->user->title}}</p>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 bottom text-center">
                                        <div class="col-xs-12 col-sm-6 emphasis">
                                            <button type="button" class="btn btn-primary btn-xs">
                                                <i class="fa fa-user"> </i> View Profile
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /MAIL LIST -->
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="//cdn.ckeditor.com/4.11.4/standard/ckeditor.js"></script>
    <script src="{{ asset('js/admin/parsleyjs/dist/parsley.js') }}"></script>
    <script>
        $(function () {
            /*if use ck editor then parsley validator works like this*/
            CKEDITOR.on('instanceReady', function () {
                $('#answer').attr('required', '');
                $.each(CKEDITOR.instances, function (instance) {
                    CKEDITOR.instances[instance].on("change", function (e) {
                        for (instance in CKEDITOR.instances) {
                            CKEDITOR.instances[instance].updateElement();
                        }
                    });
                });
            });
            CKEDITOR.replace( 'answer' );

            $("#post_answer").on('click',function (e) {
                var form = $("#answer_form");
                form.parsley().validate();
                if (form.parsley().isValid()){
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You Want Submit The Answer",
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes'
                    }).then(function (result) {
                        if (result.value) {
                            $("#answer_form").submit();
                        }
                    });
                }
            });
            $(".open_comment_box").click(function () {
                var id = $(this).attr('id');
                var url = "{{ url('/comment/on/answer') }}";
                $("#comment_form").attr('action',url+'/'+id);
            });
            $("#save_comment").click(function () {
                var form = $("#comment_form");
                form.parsley().validate();
                if (form.parsley().isValid()){
                    form.submit();
                }
            });
            $(".delete_comment").click(function () {
                var id = $(this).attr('id');
                var url = "{{url('/delete/comment')}}";
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You Want To Delete the Comment",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, Delete It'
                }).then(function (result) {
                    if (result.value) {
                        $.ajax({
                            url:url+"/"+id,
                            type:"GET",
                            contentType:false,
                            processData:false,
                            dataType:'json',
                            beforeSend:function(){
                                Swal.fire({
                                    title: 'Sending Data.......',
                                    showConfirmButton: false,
                                    html: '<i class="fa fa-spinner fa-spin" style="font-size:24px"></i>',
                                    allowOutsideClick: false
                                });
                            },
                            success:function (response) {
                                Swal.close();
                                if (response==="success"){
                                    Swal.fire({
                                        title: 'Successfully Deleted',
                                        type: 'success',
                                        showCancelButton: false,
                                        confirmButtonColor: '#3085d6',
                                        allowOutsideClick: false
                                    }).then(function (result) {
                                        if (result.value){
                                            window.location.reload();
                                        }
                                    });
                                }
                            },
                            error:function (error) {
                                Swal.close();
                                console.log(error.response);
                                Swal.fire(
                                    'Error!',
                                    'Something Went Wrong',
                                    'error'
                                )
                            }
                        });
                    }
                });
            });
            $(".edit_answer").click(function () {
                /*Scroll To Bottom Of The Page*/
                $('html, body').animate({
                        scrollTop: $(document).height()-$(window).height()
                    },
                    1500);
                /*get data, set data to form*/
                var answer = $(this).attr('data-answer');
                CKEDITOR.instances['answer'].setData(answer);
                var id = $(this).attr('id');
                var url = "{{ url('/update/answer') }}";
                $("#answer_form").attr('action',url+"/"+id);
                $("#post_answer").html("<i class='fa fa-save'></i> Update Answer");
                return false;
            });
        });
    </script>
@endsection
