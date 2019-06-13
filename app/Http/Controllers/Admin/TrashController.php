<?php

namespace App\Http\Controllers\Admin;

use App\Admin;
use App\Answer;
use App\Question;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TrashController extends Controller
{
    public function trashBoard(){
        $adminUsers = Admin::onlyTrashed()->get();
        $frontUsers = User::onlyTrashed()->get();
        $questions = Question::onlyTrashed()->get();
        $answers = Answer::onlyTrashed()->get();
        return view('back.trash.trashboard',compact(
            'adminUsers','frontUsers','questions','answers'
        ));
    }

    public function allTrashedQuestions(){
        $questions = Question::onlyTrashed()
            ->with('tags','category')
            ->orderBy('deleted_at','DESC')
            ->get();
        return view('back.trash.questions-trash')
            ->withQuestions($questions);
    }
    public function restoreTrashedQuestions($id){
        $questions = Question::onlyTrashed()
            ->find($id);
        if ($questions){
            $questions->restore();
            return response()->json('success',201);
        }
        return response()->json('error',422);

    }

    public function permanentlyDelete(Request $request){
        $ids = $request->ids;
        foreach ($ids as $id){
            $question = Question::onlyTrashed()
                ->find($id);
            if ($question){
                $question->forceDelete();
            }
        }
        return response()->json('success',201);
    }
}
