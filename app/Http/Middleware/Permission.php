<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Menu;
use App\Models\MenuPermission;

class Permission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $route = $request->route()->getName();
        // dd($route);
        $user_role_array = Auth::user()->user_role;

        $title = Menu::where('route',$route)->first();

        if(isset($user_role_array) && count($user_role_array)>0){
            foreach($user_role_array as $rolee){
                $user_role[] = $rolee->role_id;
            }
        }else{
            $user_role = [];
        }

        // dd($user_role);

        if(Auth::user()->id =='1'){
            $request->session()->put('title',@$title->name);
            return $next($request);
        }else{
            $mainmenu = Menu::where('route',$route)->first();
            // dd($mainmenu);
            // $mainmenuroute = MenuRoute::with(['menu'])->where('route',$route)->first();
            if($mainmenu != null){
                $permission=MenuPermission::whereIn('role_id',$user_role)->where('permitted_route',$route)->first();
                // dd($permission);
                if($permission){
                    $request->session()->put('title',@$title->name);
                    return $next($request);
                }else{
                    $request->session()->put('title',@$title->name);
                    return redirect()->back()->with('error','Access Permission Denied');
                }
            }else{
                $request->session()->put('title',@$title->name);
                return redirect()->back()->with('error','Access Permission Denied');
                // $request->session()->put('title',@$title->name);
                // return $next($request);
            }
        }

        return $next($request);
    }
}
