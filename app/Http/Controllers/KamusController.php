<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Kamus;

class KamusController extends Controller
{
    public function __construct(){
        $this->middleware('auth.super');
    }

    public function index(){
  	     return view('kamus');
    }

    public function data(Request $request){
	    $columns = array(

          0 =>'kata_singkatan',
          1 =>'kata_asli',
          2 =>'id',

        );

      	$limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        $totalData = Kamus::count();

        if(empty($request->input('search.value')))
        {
          $kamuss = Kamus::offset($start)
    				->limit($limit)
    				->orderBy($order,$dir)
    				->get();

          $totalFiltered = $totalData;
        }
        else {
          $search = $request->input('search.value');

          $kamuss =  Kamus::where('kata_singkatan','LIKE',"%{$search}%")
            ->offset($start)
            ->limit($limit)
            ->orderBy($order,$dir)
            ->get();

          $totalFiltered = Kamus::where('kata_singkatan','LIKE',"%{$search}%")
            ->count();
        }

        $data = array();
        foreach ($kamuss as $key=>$kamus)
        {
            $nestedData['no'] = $start+$key+1;;
            $nestedData['kata_singkatan'] = $kamus->kata_singkatan;
            $nestedData['kata_asli'] = $kamus->kata_asli;
            $nestedData['aksi'] = "<div class='btn-group'>
    					<button class='btn btn-success' onClick='editKamus($kamus->id)'><i class='fa fa-pencil'></i>&nbsp&nbsp Ubah</button>
                        <button class='btn btn-danger' onClick='deleteKamus($kamus->id)'><i class='fa fa-trash'></i>&nbsp&nbsp Hapus</button>
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
      	$kamus = new Kamus;
      	$kamus->kata_singkatan = $request->input('kata_singkatan');
      	$kamus->kata_asli = $request->input('kata_asli');

      	if($kamus->save()){
    	  	$response = array(
    	  		'status' => 'OK',
    	  		'message' => 'kamus berhasil ditambahkan'
    	  	);
      	}
      	else{
      		$response = array(
    	  		'status' => 'error',
    	  		'message' => 'kamus gagal ditambahkan'
    	  	);
      	}

      	return response()->json($response);
    }

    public function read(Request $request, $id){
      	$data = Kamus::find($id);
      	return response()->json($data);
    }

    public function update(Request $request, $id){
      	$kamus = Kamus::find($id);
      	$kamus->kata_singkatan = $request->input('kata_singkatan');
      	$kamus->kata_asli = $request->input('kata_asli');

      	if($kamus->save()){
    	  	$response = array(
    	  		'status' => 'OK',
    	  		'message' => 'kamus berhasil diperbaharui'
    	  	);
      	}
      	else{
      		$response = array(
    	  		'status' => 'error',
    	  		'message' => 'kamus gagal diperbaharui'
    	  	);
      	}

      	return response()->json($response);
    }

    public function delete(Request $request, $id){
      	$kamus = Kamus::find($id);

      	if($kamus->delete()){
      		$response = array(
    	  		'status' => 'OK',
    	  		'message' => 'kamus berhasil dihapus'
    	  	);
      	}
      	else{
      		$response = array(
    	  		'status' => 'error',
    	  		'message' => 'kamus gagal dihapus'
    	  	);
      	}

      	return response()->json($response);
    }
}
