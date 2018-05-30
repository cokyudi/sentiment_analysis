<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Admin;

class AuthController extends Controller
{
    public function login(Request $request){
      if($request->session()->has('admin')){
        return redirect('dashboard');
      }
      else {
    	  return view('login');
      }
    }

    public function logout(Request $request){
    	$request->session()->flush();
    	return redirect('login');
    }

    public function index(Request $request){
    	$username = $request->input('username');
    	$password = $request->input('password');
    	$remember_token = $request->input('remember') == 'on'?$request->input('_token'):null;

    	$admin = Admin::where('username','=',$username)->first();

    	if($admin == null){
    		$response = array(
		  		'status' => 'error',
		  		'message' => 'Username tidak terdaftar'
		  	);
    		return response()->json($response);
    	}
    	else if(password_verify($password, $admin->password)){
    		$data = array(
                'id' => $admin->id,
                'username' => $admin->username,
                'nama' => $admin->nama,
                'level' => $admin->level
	    	);
	    	$request->session()->put('admin', $data);

    		$response = array(
		  		'status' => 'OK',
		  		'message' => 'Admin terdaftar'
		  	);

			$admin->remember_token = $remember_token;
			$admin->save();

    		return response()->json($response);
    	}
    	else{
    		$response = array(
		  		'status' => 'error',
		  		'message' => 'Password salah'
		  	);
    		return response()->json($response);
    	}
    }
}
