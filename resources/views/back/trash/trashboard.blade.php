@extends('back.master')
@section('page_title')
    <div class="title_left">
        <h3><i class="fa fa-trash"></i> Trash Board</h3>
    </div>
@endsection
@section('contain')
    <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="tile-stats">
            <div class="icon"><i class="fa fa-trash-o"></i></div>
            <div class="count">{{ count($frontUsers) }}</div>
            <h3>Front Users</h3>
            <p>
                Deleted question users
            </p>
            <p>
                <a class="btn btn-xs btn-success"><i class="fa fa-eye"></i> Show List</a>
            </p>
        </div>
    </div>
    <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="tile-stats">
            <div class="icon"><i class="fa fa fa-trash-o"></i></div>
            <div class="count">{{ count($adminUsers) }}</div>
            <h3>Admin Users</h3>
            <p>Deleted Admin Users</p>
            <p>
                <a class="btn btn-xs btn-success"><i class="fa fa-eye"></i> Show</a>
            </p>
        </div>
    </div>
    <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="tile-stats">
            <div class="icon"><i class="fa fa fa-trash-o"></i></div>
            <div class="count">{{ count($questions) }}</div>
            <h3>Questions</h3>
            <p>Deleted Questions</p>
            <p>
                <a href="{{ url('all/trashed/questions') }}" class="btn btn-xs btn-success"><i class="fa fa-eye"></i> Show</a>
            </p>
        </div>
    </div>
    <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="tile-stats">
            <div class="icon"><i class="fa fa fa-trash-o"></i></div>
            <div class="count">{{ count($answers) }}</div>
            <h3>Answers</h3>
            <p>Deleted All Answers</p>
            <p>
                <a class="btn btn-xs btn-success"><i class="fa fa-eye"></i> Show</a>
            </p>
        </div>
    </div>
@endsection