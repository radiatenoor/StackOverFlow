<?php

namespace App\Http\Controllers\Admin;

use App\Admin;
use App\Permission;
use App\Role;
use App\RolePermission;
use App\UserRole;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin')/*->except('index')*/;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('back.user.list');
    }

    public function renderDataTable(){
        $admins = Admin::with('user_role.role'/*nested relation names*/)
            ->whereNotIn('id',[1])
            ->get();
        $render_table = DataTables::of($admins)
            ->addColumn('hash',function ($row){
                return '<input type="checkbox" name="admin_ids[]" value="'.$row->id.'">';
            })
            ->addColumn('action',function (){
                return '<button class="btn btn-info btn-xs"><i class="fa fa-edit"></i></button>'.
                    '<button class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></button>';
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
        return $render_table;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::orderBy('role_name','ASC')->get();
        return view('back.user.create')
            ->with('roles',$roles);
    }

    /**
     * Store new data
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request,[
           'name'=>'required',
           'email'=>'required|unique:admins',
           'password'=>'required|confirmed|min:6',
           'role'=>'required'
        ]);

        $admin = new Admin();
        $admin->name = $request->name;
        $admin->email = $request->email;
        $admin->password = bcrypt($request->password);
        if ($request->hasFile('photo')){
            $image = $request->file('photo');
            $filename = time().".".$image->getClientOriginalExtension();
            $path = public_path('images/');
            $image->move($path,$filename);
            $admin->photo = $filename;
        }
        $admin->active =1;
        $admin->save();

        /*
         * when use relationship function name to save data, you need to
         * use fillable property in that relationship model
        */
        $admin->role()->save(new UserRole(['role_id'=>$request->role]));

        /* same way to save data in user role model */
        /* $role = new UserRole();
        $role->admin_id = $admin->id;
        $role->role_id = $request->role;
        $role->save(); */

        Session::flash('success','You Have Successfully Register An Admin');
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
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        return view('back.user.edit');
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


    /**
     * Role Permission View
     * @return $this
     */
    public function roles_permissions(){
        $roles = Role::all();
        $permissions = Permission::all();
        return view('back.role_permission.role_permission')
            ->with('roles',$roles)
            ->with('permissions',$permissions);
    }

    public function assignRole(Request $request){
        $this->validate($request,[
           'role'=>'required|unique:role_permissions,role_id',
           'permission'=>'required|array|min:1'
        ]);

        $role = Role::find($request->role);
        $role->permissions()->attach($request->permission);

        Session::flash('success','You Have Successfully Assigned Role');
        return redirect()->back();
    }

    public function updateAssignRole(Request $request,$id){
        $this->validate($request,[
            'role'=>'required',
            'permission'=>'required|array|min:1'
        ]);

        $role = Role::find($request->role);
        $role->permissions()->sync($request->permission);

        Session::flash('success','You Have Successfully Updated Assigned Role');
        return redirect()->back();
    }

}
