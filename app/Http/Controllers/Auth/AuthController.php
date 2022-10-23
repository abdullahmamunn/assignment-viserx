<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;


class AuthController extends Controller
{
    public function loginForm()
    {
        return view('auth.login');
    }

    public function registationForm()
    {
        return view('auth.registration');
    }

    public function UserRegistationFormSubmit(Request $request)
    {
       $request->validate([
           'name' => 'required',
           'email' => 'required|unique:users,email',
           'password' => 'required|confirmed|min:6'
       ]);

    //    $data = $request->except('_token','password_confirmation');

       User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password)
       ]);
      return redirect('login');

    }

    public function UserLoginFormSubmit(Request $request)
    {
        // return $request->all();
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        // Custom guard

        // dd(Auth::guard('user_info')->attempt($request->only(['email','password'])));

        // if(Auth::guard('user_info')->attempt($request->only(['email','password']))){
        //     echo "ok";
        //     die();
        //    return redirect()->intended('dashboard');

        // }
        $user_credentials = $request->only('email','password');
        // dd(Auth::attempt($user_credentials));

       if(Auth::attempt($user_credentials)){
           return redirect()->route('dashboard')->with('success','Login successfull, Mr.');
       }
       return redirect()->route('login')->with('error','Your credential doesnot match');


  }

public function getData()
{
    $users = User::all();
    return view('get-data',compact('users'));
}



    public function dashboard()
    {
        return view('auth.dashboard');
    }
    public function logout(Request $request)
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
