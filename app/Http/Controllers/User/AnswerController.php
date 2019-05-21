<?php

namespace App\Http\Controllers\User;

use App\Answer;
use App\Comment;
use App\Rules\StripThenLength;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;

class AnswerController extends Controller
{
    public function answeredList(){
        $answers = Answer::where('user_id',Auth::id())
            ->orderBy('id','desc')->get();
        return view('front.answer.list')
            ->with('answers',$answers);
    }

    public function getDataTableAnsweredList(){
        $answers = Answer::where('user_id',Auth::id())
            ->orderBy('id','desc')->get();
        $customAnswer = [];
        foreach ($answers as $row){
            $customAnswer[] = [
                'id'=>$row->id,
                'title'=>strlen($row->question->title)>10?
                    substr($row->question->title,0,10)."......":
                    $row->question->title,
                'answer'=>strlen(strip_tags($row->answer))>10?
                    substr(strip_tags($row->answer),0,10)."......":
                    $row->answer,
                'date'=>''.$row->created_at
            ];
        }
        $data_table_render = DataTables::of($customAnswer)
            ->addColumn('hash',function ($row){
                return $row['id'];
            })
            ->addColumn('action',function ($row){
                $edit_url = route('edit.question',$row['id']);
                $view_url = route('view.question',$row['id']);
                return '<a href="'.$edit_url.'" class="btn btn-success btn-xs"><i class="fa fa-edit"></i></a>'.
                    '<a href="'.$view_url.'" class="btn btn-info btn-xs"><i class="fa fa-eye"></i></a>'.
                    '<button type="button" onclick="deletes('.$row['id'].')" class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i></button>';
            })
            ->rawColumns(['hash','action'])
            ->make(true);
        return $data_table_render;
    }

    public function saveAnswer(Request $request,$question_id){
        //validation
        $this->validate($request,[
            'answer'=>['required',new StripThenLength(6)],
        ]);

        $answers = new Answer();
        $answers->question_id = $question_id;
        $answers->user_id = Auth::user()->id;
        $answers->answer = $request->answer;
        $answers->status = 1;
        $answers->save();
        Session::flash('success','You Have Successfully Save The Answered');
        return redirect()->back();
    }

    public function updateAnswer(Request $request,$answer_id){
        $this->validate($request,[
            'answer'=>['required',new StripThenLength(6)],
        ]);

        $answers = Answer::where('user_id',Auth::user()->id)->find($answer_id);
        $answers->answer = $request->answer;
        $answers->save();

        Session::flash('success','You Have Successfully Updated The Answered');
        return redirect()->back();
    }

    public function makeComments(Request $request,$answered_id){
        //validation
        $this->validate($request,[
            'comment'=>['required',new StripThenLength(6)],
        ]);

        $comments = new Comment();
        $comments->answer_id = $answered_id;
        $comments->user_id = Auth::user()->id;
        $comments->comment = $request->comment;
        $comments->save();

        Session::flash('success','You Have Successfully Save Comment');
        return redirect()->back();
    }

    public function deleteComment($comment_id){
        $comment = Comment::where('user_id',Auth::user()->id)
            ->where('id',$comment_id)
            ->first();
        if ($comment){
            $comment->delete();
            return response()->json('success',201);
        }
        return response()->json('error',422);
    }
}
