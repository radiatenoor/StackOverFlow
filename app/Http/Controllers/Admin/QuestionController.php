<?php

namespace App\Http\Controllers\Admin;

use App\Question;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class QuestionController extends Controller
{
    public function pending(){
        $questions = Question::where('status',0)
            ->with('tags','category','user')
            ->orderBy('id','DESC')
            ->paginate(5);
        return view('back.questions.pending-list')
            ->with('questions',$questions);
    }

    public function viewPending($id){
       $question = Question::where('status',0)->find($id);
       if (!$question){
           abort(404);
       }
       return view('back.questions.pending',compact('question'));
    }

    public function approveQuestion($id){
        $question = Question::find($id);
        if ($question){
            $question->status = 1;
            $question->save();
            return response()->json('success',201);
        }
        return response()->json('error',422);
    }

    public function renderApprovedDataTable(){
        $questions = Question::where('status',1)
            ->with('tags','category')
            ->get();
        $render = DataTables::of($questions)
            ->addColumn('hash',function ($row){
                return $row->id;
            })
            ->addColumn('action',function ($row){
                $view_url = route('view.approved.question',$row->id);
                return '<a href="'.$view_url.'" class="btn btn-info btn-xs"><i class="fa fa-eye"></i></a>'.
                    '<button type="button" onclick="deletes('.$row->id.')" class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i></button>';
            })
            ->editColumn('status',function ($row){
                $htmlElement = "";
                if ($row->status==1){
                    $htmlElement = '<button class="btn btn-success btn-xs">Active</button>';
                }else{
                    $htmlElement = '<button class="btn btn-danger btn-xs">Inactive</button>';
                }
                return $htmlElement;
            })
            ->editColumn('tags',function ($row){
                $htmlElement = '';
                foreach ($row->tags as $tag){
                    $htmlElement .= '<button class="btn btn-success btn-xs">'.$tag->name.'</button>';
                }
                return $htmlElement;
            })
            ->rawColumns(['tags','status','action'])
            ->make(true);

        return $render;
    }

    public function allApprovedQuestions(){
        return view('back.questions.approved-list');
    }

    public function viewApproved($id){
        $question = Question::where('status',1)->find($id);
        if (!$question){
            abort(404);
        }
        return view('back.questions.approved',compact('question'));
    }

    public function deleteQuestion($id){
        $questions = Question::find($id);
        if ($questions){
            $questions->delete();
            return response()->json('success',201);
        }
        return response()->json('error',422);
    }
}
