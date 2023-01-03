<?php

namespace App\Http\Controllers\Admin\Users\Roles;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Support\Str;

class RolesController extends Controller
{
    public function show_roles()
    {
        // $admin = Admin::find(2);
        // $admin->attachPermission('user_manage');
        // $role = \App\Models\Role::find(2);
        // $role->attachPermission('user_manage');
        // return dd(auth()->user()->allPermissions());
        $roles = Role::all();
        return view('admin.roles.showRoleUser',compact('roles'));
    }
    public function show_add()
    {
        $permissions = Permission::all();
        return view('admin.roles.addRoleUser', compact('permissions'));
    }
    public function save_role(Request $request)
    {
        $request->validate([
            "display_name" => "required|string",
            "description" => "required|string",
            "id" => "required|array|min:1",
        ],[
            "required"=>"يجب ان يتواجد على الاقل صلاحية واحدة لحفظ الدور",
            "array"=>"يجب ان يتواجد على الاقل صلاحية واحدة لحفظ الدور"
        ]);

       // try{

            $new_role = \App\Models\Role::create([
                'name' => Str::random(15),
                'display_name'=> $request->display_name,
                'description' => $request->description
            ]);
            $new_role->attachPermissions($request->id);
            $request->session()->flash('status', 'تم إضافة الدور بنجاح');
            return back();
        // }catch(\Exception $ex){
        //     return $ex->getMessage();
        //     $request->session()->flash('error', 'خطاء فى البيانات المدخلة');
        //     return back();
        // }
    }

    public function update_show($id)
    {
        $role = Role::find($id);
        if($role !== null){
            $permissions = Permission::all();
            $class = '';
            return view('admin.roles.updateRoleUser',compact('role', 'permissions' , 'class'));
        }else{
            return back();
        }
    }
    public function update_save(Request $request)
    {
        $request->validate([
            "display_name" => "required|string",
            "description" => "required|string",
            "role_id" => "required|numeric",
            "id" => "required|array|min:1",
        ],[
            "required"=>"يجب ان يتواجد على الاقل صلاحية واحدة لحفظ الدور",
            "array"=>"يجب ان يتواجد على الاقل صلاحية واحدة لحفظ الدور"
        ]);
        $role = Role::find($request->role_id);
        if($role !== null){
            $role->display_name = $request->display_name;
            $role->description = $request->description;
            $role->save();
            $role->syncPermissions($request->id);
            return back();
        }else{
            return back();
        }
    }

}
