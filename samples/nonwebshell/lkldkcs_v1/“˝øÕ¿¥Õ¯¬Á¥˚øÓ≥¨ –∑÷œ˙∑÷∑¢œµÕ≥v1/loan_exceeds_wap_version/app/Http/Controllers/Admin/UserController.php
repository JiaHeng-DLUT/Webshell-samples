<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $roles=Role::where(['type'=>'admin'])->get();
        $users=User::select()->where(['role_slug'=>'admin']);
        if($role_id=$request->input('role_id','')){
            $users=$users->whereHas('roles',function($query) use ($role_id){
                $query->where(['id'=>$role_id]);
            });

        }
        $users=$users->orderBy('status','desc')->orderBy('id','asc')->paginate($request->get('limit', 10));
        return view('admin.user.index',['users'=>$users,'roles'=>$roles]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user=new User();
        $roles=Role::where(['type'=>'admin'])->get();
        return view('admin.user.create',compact('user','roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserCreateRequest $request)
    {
        $data = $request->except('role_id');
        $data['uuid'] = \Faker\Provider\Uuid::uuid();
        $data['password'] = bcrypt($data['password']);
        $data['status']=1;
        $data['role_slug']='admin';
        $role_id=$request->input('role_id');
        if ($user=User::create($data)){
            $user->syncRoles([$role_id]);
            return redirect()->to(route('admin.user'))->with(['status'=>'添加用户成功']);
        }
        return redirect()->to(route('admin.user'))->withErrors('系统错误');
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
        $user = User::findOrFail($id);
        $roles=Role::where(['type'=>'admin'])->get();
        return view('admin.user.edit',compact('user','roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserUpdateRequest $request, $id)
    {
        $user = User::findOrFail($id);
        $data = $request->except('password');
        if ($request->get('password')){
            $data['password'] = bcrypt($request->get('password'));
        }
        $role_id=$request->input('role_id');
        if ($user->update($data)){
            $user->syncRoles([$role_id]);
            return redirect()->to(route('admin.user'))->with(['status'=>'更新用户成功']);
        }
        return redirect()->to(route('admin.user'))->withErrors('系统错误');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id=$request->route('id');
        $user=User::find($id);
        if (!$user){
            return response()->json(['code'=>1,'msg'=>'用户不存在或已被删除']);
        }
        if($user->isRoot()){
            return response()->json(['code'=>1,'msg'=>'不能删除超管']);
        }
        if ($user->delete()){
            return response()->json(['code'=>0,'msg'=>'删除成功']);
        }else{
            return response()->json(['code'=>1,'msg'=>'删除失败']);
        }
    }

    /**
     * 分配角色
     */
    public function role(Request $request,$id)
    {
        $user = User::findOrFail($id);
        $roles = Role::get();
        $hasRoles = $user->roles();
        foreach ($roles as $role){
            $role->own = $user->hasRole($role) ? true : false;
        }
        return view('admin.user.role',compact('roles','user'));
    }

    /**
     * 更新分配角色
     */
    public function assignRole(Request $request,$id)
    {
        $user = User::findOrFail($id);
        $roles = $request->get('roles',[]);
       if ($user->syncRoles($roles)){
           return redirect()->to(route('admin.user'))->with(['status'=>'更新用户角色成功']);
       }
        return redirect()->to(route('admin.user'))->withErrors('系统错误');
    }

    /**
     * 分配权限
     */
    public function permission(Request $request,$id)
    {
        $user = User::findOrFail($id);
        $permissions = $this->tree();
        foreach ($permissions as $key1 => $item1){
            $permissions[$key1]['own'] = $user->hasDirectPermission($item1['id']) ? 'checked' : false ;
            if (isset($item1['_child'])){
                foreach ($item1['_child'] as $key2 => $item2){
                    $permissions[$key1]['_child'][$key2]['own'] = $user->hasDirectPermission($item2['id']) ? 'checked' : false ;
                    if (isset($item2['_child'])){
                        foreach ($item2['_child'] as $key3 => $item3){
                            $permissions[$key1]['_child'][$key2]['_child'][$key3]['own'] = $user->hasDirectPermission($item3['id']) ? 'checked' : false ;
                        }
                    }
                }
            }
        }
        return view('admin.user.permission',compact('user','permissions'));
    }

    /**
     * 存储权限
     */
    public function assignPermission(Request $request,$id)
    {
        $user = User::findOrFail($id);
        $permissions = $request->get('permissions');

        if (empty($permissions)){
            $user->permissions()->detach();
            return redirect()->to(route('admin.user'))->with(['status'=>'已更新用户直接权限']);
        }
        $user->syncPermissions($permissions);
        return redirect()->to(route('admin.user'))->with(['status'=>'已更新用户直接权限']);
    }


    /**
     * 修改密码展示页面
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showPasswordForm(){

        return view('admin.user.password');
    }


    /**
     * 修改密码
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function password(Request $request){

        $this->validate($request,[
           'oldPassword'=>'required',
           'password'=>'regex:/^[^\s]*$/|required|between:6,18|confirmed',
        ],[
            'oldPassword.required'=>'请输入原密码',
            'password.regex'=>'新密码不能包含空格字符',
            'password.required'=>'请输入新密码',
            'password.between'=>'密码长度为6~18位',
            'password.confirmed'=>'两次密码输入不一致',
        ]);

        $old_password=$request->input('oldPassword');
        $password=$request->input('password');
        if(!Hash::check($old_password,auth()->user()->password)){
            return response()->json(['code'=>1,'msg'=>'原密码错误,请重新输入']);
        }
        if(User::where(['id'=>auth()->user()->id])->update(['password'=>bcrypt($password)])){

            return response()->json(['code'=>0,'msg'=>'修改成功,请重新登录']);
        }else{
            return response()->json(['code'=>1,'msg'=>'修改失败']);
        }
    }


    public function status(Request $request){

        $status=$request->input('status');
        $user_id=$request->input('user_id');
        $user=User::find($user_id);
        if(!$user){
            return response()->json(['code'=>1,'msg'=>'用户不存在或已被删除']);
        }
        if(in_array('root',$user->roles->pluck('name')->all()) && $status=='1'){
            return response()->json(['code'=>1,'msg'=>'不能禁用超级管理员']);
        }
        if($status==1){
            $user->status=0;
        }else{
            $user->status=1;
        }
        if($user->save()){
            return response()->json(['code'=>0,'msg'=>'操作成功','status'=>$user->status]);
        }else{
            return response()->json(['code'=>1,'msg'=>'操作失败']);
        }
    }

}















