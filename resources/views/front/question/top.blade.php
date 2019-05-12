@extends('front.master')
@section('page_title')
    <div class="title_left">
        <h3>Top Question</h3>
    </div>
@endsection
@section('stylesheet')

@endsection
@section('contain')
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Top Question</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <a href="{{url('new/question')}}" class="btn btn-info btn-md">Ask Question</a><br>
                <div class="btn-group">
                    <a href="{{url('top/question?day=today')}}" class="btn btn-sm {{ $activeParamBtn=='today'?'btn-primary':'btn-default' }}" type="button"><i class="fa fa-times-circle"></i> Today</a>
                    <a href="{{url('top/question?day=week')}}" class="btn btn-sm {{ $activeParamBtn=='week'?'btn-primary':'btn-default' }}" type="button"><i class="fa fa-times-circle"></i> Week</a>
                    <a href="{{url('top/question?day=month')}}" class="btn btn-sm {{ $activeParamBtn=='month'?'btn-primary':'btn-default' }}" type="button"><i class="fa fa-times-circle"></i> Month</a>
                </div>
                <div class="ln_solid"></div>
                <div class="table-responsive">
                    <table id="question_table" class="table table-bordered">
                        <tbody>
                        @foreach($question as $row)
                            <tr>
                                <th style="width: 100px">
                                    <button class="btn btn-default">Views
                                        <br>
                                        <span class="badge badge-danger">3</span>
                                    </button>
                                </th>
                                <th style="width: 120px">
                                    <button class="btn btn-default">Answer
                                        <br>
                                        <span class="badge badge-danger">{{ isset($row->answers)?count($row->answers):0 }}</span>
                                    </button>
                                </th>
                                <th style="width: 100px">
                                    <button class="btn btn-default">
                                        Vote
                                        <br>
                                        <span class="badge badge-danger">{{ isset($row->votes)?count($row->votes):0 }}</span>
                                    </button>
                                </th>
                                <th>
                                    <a href="{{route('show.question',$row->id)}}" style="font-size: 20px">{{ $row->title }}</a>
                                    <br>
                                    @foreach($row->tags as $tag)
                                      <button class="btn btn-info btn-xs"><i class="fa fa-tag"></i> {{$tag->name}}</button>
                                    @endforeach
                                    <br>
                                    <p style="color: #9d6f5e; font-size: 10px;">Asked {{ $row->created_at }} By {{ $row->user->name }}</p>
                                </th>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{ $question->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')

@endsection
