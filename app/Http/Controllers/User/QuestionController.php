<?php

namespace App\Http\Controllers\User;

use App\Category;
use App\Question;
use App\Tag;
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
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
                return '<button class="btn btn-info btn-xs"><i class="fa fa-edit"></i></button>'.
                    '<button class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i></button>';
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
}
