<?php

namespace App\Http\Controllers\User;

use App\Answer;
use App\Category;
use App\Comment;
use App\Question;
use App\Rules\StripThenLength;
use App\Tag;
use App\UpVote;
use App\Vote;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;
class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $question = Question::where('user_id',Auth::user()->id)->get();
        return view('front.question.list',compact('question'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category = Category::all();
        $tags = Tag::all();
        return view('front.question.new')
            ->with('categories',$category)
            ->with('tags',$tags);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        //1. validation
        $this->validate($request,[
            'title'=>'required|min:6',
            'category'=>'required',
            'tag'=>'required|array|min:1',
            'description'=>'required|min:10'
        ]);
        // 2. data insert
        $quest = new Question();
        $quest->title = $request->title;
        $quest->category_id = $request->category;
        $quest->user_id = Auth::user()->id;
        $quest->description = $request->description;
        $quest->status = 1;
        $quest->save();

        // data insert in many to many relationship/link table
        $quest->tags()->attach($request->tag);

        //message
        Session::flash('success','Succesfully Data Saved');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $question = Question::find($id);
        return view('front.question.show')
            ->with('question',$question);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $question = Question::where('user_id',Auth::user()->id)->find($id);
        $question_tag = [];
        $i=0;
        foreach ($question->tags as $tag){
            $question_tag[$i] = $tag->id;
            $i++;
        }
        $category = Category::all();
        $tags = Tag::all();
        return view('front.question.edit')
            ->with('question',$question)
            ->with('question_tag',$question_tag)
            ->with('tags',$tags)
            ->with('categories',$category);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, $id)
    {
        //1. validation
        $this->validate($request,[
            'title'=>'required|min:6',
            'category'=>'required',
            'tag'=>'required|array|min:1',
            'description'=>'required|min:10'
        ]);
        // 2. data insert
        $quest = Question::find($id);
        $quest->title = $request->title;
        $quest->category_id = $request->category;
        $quest->description = $request->description;
        $quest->save();

        // data insert in many to many relationship/link table
        $quest->tags()->sync($request->tag);

        return response()->json('success',201);
    }


    public function destroy($id)
    {
        $question = Question::where('user_id',Auth::id())->find($id);
        if ($question){
            $question->delete();
            return response()->json('success',201);
        }
        return response()->json('error',201);
    }

    public function questionData(){
        $customData=[];
        $question = Question::where('user_id',Auth::user()->id)
            ->with('tags:name','category')
            ->orderBy('id','DESC')
            ->get();

        $data_table_render = DataTables::of($question)
            ->addColumn('hash',function ($row){
                return $row->id;
            })
            ->addColumn('action',function ($row){
                $edit_url = route('edit.question',$row->id);
                $show_url = route('show.question',$row->id);
                return '<a href="'.$edit_url.'" class="btn btn-success btn-xs"><i class="fa fa-edit"></i></a>'.
                    '<a href="'.$show_url.'" class="btn btn-info btn-xs"><i class="fa fa-eye"></i></a>'.
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
        return $data_table_render;
    }

    public function topQuestion(Request $request){

        $today = date('Y-m-d');

        /*get the value of url parameter*/
        $getParams = $request->input('day');

        $query = Question::orderBy('id','DESC');
        if ($getParams=="today"){
            $query->whereDate('created_at',$today);
        }else if($getParams=="week"){
            $date = new \DateTime($today);
            $date->modify('-7 day');
            $prevWeekDate = $date->format('Y-m-d');
            $query->whereDate('created_at','<=',$today);
            $query->whereDate('created_at','>=',$prevWeekDate);
        }else if($getParams=="month"){
            $date = new \DateTime($today);
            $date->modify('-30 day');
            $prevMonthDate = $date->format('Y-m-d');
            $query->whereDate('created_at','<=',$today);
            $query->whereDate('created_at','>=',$prevMonthDate);
        }

        /*paginate the result*/
        $question = $query->paginate(5);
        /*attach the url parameter with pagination link*/
        $question->appends(['day'=>$getParams]);

        return view('front.question.top')
            ->with('question',$question)
            ->with('activeParamBtn',$getParams);
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

    public function vote($id){
        $vote = new Vote();
        $vote->question_id = $id;
        $vote->user_id = Auth::user()->id;
        $vote->save();

        Session::flash('success','Up Vote Successfully Done');
        return redirect()->back();
    }
    public function cancelVote($id){
        $vote = Vote::where('question_id',$id)
            ->where('user_id',Auth::user()->id)
            ->first();
        $vote->delete();

        Session::flash('success','Down Vote Successfully Done');
        return redirect()->back();
    }
}
