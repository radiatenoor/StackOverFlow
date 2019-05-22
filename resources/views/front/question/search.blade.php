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
                <form class="form-horizontal" action="{{route('search.question')}}" method="post">
                    @csrf
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Question <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" id="title" name="title"
                                   class="form-control col-md-7 col-xs-12" placeholder="Search Question here...." required>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                            <button type="submit" class="btn btn-success" value="validate"><i class="fa fa-search"></i> Search</button>
                        </div>
                    </div>
                </form>
                <div class="ln_solid"></div>
                <div class="table-responsive">
                    <table id="question_table" class="table table-bordered">
                        <tbody>
                        @forelse($questions as $row)
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
                        @empty
                            <tr>
                                <th colspan="4">No Data Found</th>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                    @if(count($questions)>0)
                       {{ $questions->links() }}
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')

@endsection
