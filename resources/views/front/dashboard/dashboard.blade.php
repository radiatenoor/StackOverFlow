@extends('front.master')
@section('page_title')
    <div class="title_left">
        <h3>Dashboard</h3>
    </div>
@endsection
@section('contain')
    <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="tile-stats">
            <div class="icon"><i class="fa fa-caret-square-o-right"></i></div>
            <div class="count">179</div>
            <h3>Answered Question</h3>
            <p>Lorem ipsum psdea itgum rixt.</p>
        </div>
    </div>
    <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="tile-stats">
            <div class="icon"><i class="fa fa-caret-square-o-right"></i></div>
            <div class="count">179</div>
            <h3>Un Answered</h3>
            <p>Lorem ipsum psdea itgum rixt.</p>
        </div>
    </div>
    <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="tile-stats">
            <div class="icon"><i class="fa fa-caret-square-o-right"></i></div>
            <div class="count">179</div>
            <h3>You Answered</h3>
            <p>Lorem ipsum psdea itgum rixt.</p>
        </div>
    </div>
    <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="tile-stats">
            <div class="icon"><i class="fa fa-caret-square-o-right"></i></div>
            <div class="count">179</div>
            <h3>You Comment</h3>
            <p>Lorem ipsum psdea itgum rixt.</p>
        </div>
    </div>
    <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="tile-stats">
            <div class="icon"><i class="fa fa-caret-square-o-right"></i></div>
            <div class="count">179</div>
            <h3>Up Vote</h3>
            <p>Lorem ipsum psdea itgum rixt.</p>
        </div>
    </div>
    <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="tile-stats">
            <div class="icon"><i class="fa fa-caret-square-o-right"></i></div>
            <div class="count">179</div>
            <h3>Down Vote</h3>
            <p>Lorem ipsum psdea itgum rixt.</p>
        </div>
    </div>
    <div class="col-md-12 col-lg-12">
        <label>Tags------------</label>
        <br>
        <hr>
        @foreach($tags as $row)
           <a href="" class="btn btn-danger btn-xs">{{$row->name}}
               <span class="badge badge-danger">{{count($row->questions)}}</span>
           </a>
        @endforeach
    </div>
@endsection