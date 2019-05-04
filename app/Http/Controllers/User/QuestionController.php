<?php

namespace App\Http\Controllers\User;

use App\Category;
use App\Question;
use App\Tag;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

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
        //
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
}
