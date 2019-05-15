<?php

namespace App\Http\Controllers\User;

use App\Answer;
use App\Comment;
use App\Rules\StripThenLength;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AnswerController extends Controller
{
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
