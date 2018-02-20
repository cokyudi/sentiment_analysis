<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Admin;


class AdminController extends Controller
{
    public function __construct(){
        $this->middleware('auth.super');
    }

    public function index(){
  	     return view('admin');
    }

    public function data(Request $request){
	    $columns = array(
          0 =>'nama',
          1 =>'level',
          2 => 'username',
          3 => 'id',

    );

      	$limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        $totalData = Admin::count();

        if(empty($request->input('search.value')))
        {
          $admins = Admin::offset($start)
    				->limit($limit)
    				->orderBy($order,$dir)
    				->get();

          $totalFiltered = $totalData;
        }
        else {
          $search = $request->input('search.value');

          $admins =  Admin::where('nama','LIKE',"%{$search}%")
            ->offset($start)
            ->limit($limit)
            ->orderBy($order,$dir)
            ->get();

          $totalFiltered = Admin::where('nama','LIKE',"%{$search}%")
            ->count();
        }

        $data = array();
        foreach ($admins as $admin)
        {
            $nestedData['nama'] = $admin->nama;
            $nestedData['level'] = $admin->level==1?'Super Admin':'Admin';
            $nestedData['username'] = $admin->username;
            $nestedData['aksi'] = "<div class='btn-group'>
    					<button class='btn btn-success' onClick='editAdmin($admin->id)'><i class='fa fa-pencil'></i>&nbsp&nbsp Ubah</button>
    					<button class='btn btn-warning' onClick='changePasswordAdmin($admin->id)'><i class='fa fa-key'></i>&nbsp&nbsp Ganti Password</button>
                        <button class='btn btn-danger' onClick='deleteAdmin($admin->id)'><i class='fa fa-trash'></i>&nbsp&nbsp Hapus</button>
            </div>";
            $data[] = $nestedData;

        }

        $response = array(
          "draw"            => intval($request->input('draw')),
          "recordsTotal"    => intval($totalData),
          "recordsFiltered" => intval($totalFiltered),
          "data"            => $data
        );

        return response()->json($response);

    }

    public function store(Request $request){
      	$admin = new Admin;
      	$admin->nama = $request->input('nama');
      	$admin->level = $request->input('level');
        $admin->username = $request->input('username');
      	$admin->password = password_hash($request->input('password'), PASSWORD_BCRYPT);

      	if($admin->save()){
    	  	$response = array(
    	  		'status' => 'OK',
    	  		'message' => 'Admin berhasil ditambahkan'
    	  	);
      	}
      	else{
      		$response = array(
    	  		'status' => 'error',
    	  		'message' => 'Admin gagal ditambahkan'
    	  	);
      	}

      	return response()->json($response);
    }

    public function read(Request $request, $id){
      	$data = Admin::find($id);
      	return response()->json($data);
    }

    public function update(Request $request, $id){
      	$admin = Admin::find($id);
      	$admin->nama = $request->input('nama');
      	$admin->level = $request->input('level');
        $admin->username = $request->input('username');

      	if($admin->save()){
    	  	$response = array(
    	  		'status' => 'OK',
    	  		'message' => 'Admin berhasil diperbaharui'
    	  	);
      	}
      	else{
      		$response = array(
    	  		'status' => 'error',
    	  		'message' => 'Admin gagal diperbaharui'
    	  	);
      	}

      	return response()->json($response);
    }

    public function delete(Request $request, $id){
      	$admin = Admin::find($id);

      	if($admin->delete()){
      		$response = array(
    	  		'status' => 'OK',
    	  		'message' => 'Admin berhasil dihapus'
    	  	);
      	}
      	else{
      		$response = array(
    	  		'status' => 'error',
    	  		'message' => 'Admin gagal dihapus'
    	  	);
      	}

      	return response()->json($response);
    }

    public function updatePassword(Request $request, $id){
        $admin = Admin::find($id);

        $admin->password = password_hash($request->input('password'), PASSWORD_BCRYPT);
        if($admin->save()){
          $response = array(
            'status' => 'OK',
            'message' => 'Password admin berhasil diganti'
          );
        }
        else{
          $response = array(
            'status' => 'error',
            'message' => 'Password admin gagal diganit'
          );
        }
        return response()->json($response);
    }

}
