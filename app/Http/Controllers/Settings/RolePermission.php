<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\User;
use App\Models\UserRole;
use App\Models\Menu;
use App\Models\MenuPermission;
use Illuminate\Support\Facades\DB;

class RolePermission extends Controller
{
    public function assignRole()
    {
        $users = User::all();
        return view('settings.users',compact('users'));
    }

    public function assignUserRole($id)
    {
        $roles = Role::latest()->get();
        $user = User::find($id);
        return view('settings.assign-role',compact('user','roles'));

    }

    public function userRoleStore(Request $request)
    {
        //  return $request->all();
         $user = UserRole::where('user_id',$request->user_id)
                            ->first();
        if($user){
            if($user->role_id == $request->role_id and $user->user_id == $request->user_id)
            {
                return "User role already exist";
            }
            $user->role_id = $request->role_id;
            $user->save();
            return "update user role";
        }

        $new_user_role = new UserRole();
        $new_user_role->role_id = $request->role_id;
        $new_user_role->user_id = $request->user_id;
        $new_user_role->save();
        return "success";

    }


    public function assignRoute()
    {
        $data['roles'] = Role::all();
        $data['routes'] = Menu::where('status',1)->get();
        return view('settings.assign-route-permission',$data);
    }

    public function userRouteStore(Request $request)
    {
        // return $request->all();
        $isExist = MenuPermission::where('role_id',$request->role_id)->first();
        if($isExist){
            try {
                DB::table('menu_permissions')->delete();
                // MenuPermission::delete();
                foreach ($request->menu_id as $ml){
                    $split_data = explode('@', $ml);
                    $p = new MenuPermission;
                    $p->role_id = $request->role_id;
                    $p->menu_id 		= explode('=', $split_data[0])[1];
                    $p->permitted_route = explode('=', $split_data[1])[1];
                    $p->save();
                }
                return 'Menu Permission has saved successfully';
            } catch (\Exception $e) {

                return $e->getMessage();
            }
        }

        try {
            // MenuPermission::delete();
            foreach ($request->menu_id as $ml){
                $split_data = explode('@', $ml);
                $p = new MenuPermission;
                $p->role_id = $request->role_id;
                $p->menu_id 		= explode('=', $split_data[0])[1];
                $p->permitted_route = explode('=', $split_data[1])[1];
                $p->save();
            }
            return 'Menu Permission has saved successfully';
        } catch (\Exception $e) {
            return $e->getMessage();
        }


    }
}
