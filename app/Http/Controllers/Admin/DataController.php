<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class DataController extends Controller
{
    public function renderUserDataTable(){
        $users = User::orderBy('id','DESC')->get();
        $datatable = DataTables::of($users)
            ->addColumn('hash',function ($row){
                return '<input type="checkbox" name="user_ids[]" value="'.$row->id.'">';
            })
            ->addColumn('action',function ($row){
                return '<a href="'.url("view/user/".$row->id).'" class="btn btn-info btn-xs"><i class="fa fa-eye-slash"></i></a>'.
                    '<button class="btn btn-danger btn-xs" onclick="deleteUser('.$row->id.')"><i class="fa fa-trash"></i></button>';
            })
            ->editColumn('active',function ($row){
                $html = '';
                if ($row->active==1){
                    $html = '<button class="btn btn-xs btn-success"><i class="fa fa-check"></i> Active</button>';
                }else{
                    $html = '<button class="btn btn-xs btn-danger"><i class="fa fa-close"></i> Deactivate</button>';
                }
                return $html;
            })
            ->rawColumns(['hash','action','active'])
            ->make(true);

        return $datatable;
    }
    public function users(){
        return view('back.front-user.list');
    }

    public function deleteAll(Request $request){
        $ids = $request->user_ids;
        foreach ($ids as $id){
            $user = User::find($id);
            if ($user){
                $user->delete();
            }
        }
        return response()->json('success',201);
    }

    public function activateAll(Request $request){
        $ids = $request->user_ids;
        foreach ($ids as $id){
            $user = User::find($id);
            if ($user){
                $user->active=1;
                $user->save();
            }
        }
        return response()->json('success',201);
    }

    public function deactivateAll(Request $request){
        $ids = $request->user_ids;
        foreach ($ids as $id){
            $user = User::find($id);
            if ($user){
                $user->active=0;
                $user->save();
            }
        }
        return response()->json('success',201);
    }

    public function view($id){
        $user = User::find($id);
        return view('back.front-user.user-profile')
            ->with('user',$user);
    }

    public function delete($id){
        $user = User::find($id);
        if ($user){
            $user->delete();
            return response()->json('success',201);
        }
        return response()->json('error',422);
    }
}
