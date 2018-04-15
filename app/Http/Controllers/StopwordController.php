<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Stopword;

class StopwordController extends Controller
{
    public function __construct(){
        $this->middleware('auth.super');
    }

    public function index(){
  	     return view('stopword');
    }

    public function data(Request $request){
	    $columns = array(

          0 =>'kata',
          1 =>'id',

        );

      	$limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        $totalData = Stopword::count();

        if(empty($request->input('search.value')))
        {
          $stopwords = Stopword::offset($start)
    				->limit($limit)
    				->orderBy($order,$dir)
    				->get();

          $totalFiltered = $totalData;
        }
        else {
          $search = $request->input('search.value');

          $stopwords =  Stopword::where('kata','LIKE',"%{$search}%")
            ->offset($start)
            ->limit($limit)
            ->orderBy($order,$dir)
            ->get();

          $totalFiltered = Stopword::where('kata','LIKE',"%{$search}%")
            ->count();
        }

        $data = array();
        foreach ($stopwords as $key=>$stopword)
        {
            $nestedData['no'] = $start+$key+1;
            $nestedData['kata'] = $stopword->kata;
            $nestedData['aksi'] = "<div class='btn-group'>
    					<button class='btn btn-success' onClick='editStopword($stopword->id)'><i class='fa fa-pencil'></i>&nbsp&nbsp Ubah</button>
                        <button class='btn btn-danger' onClick='deleteStopword($stopword->id)'><i class='fa fa-trash'></i>&nbsp&nbsp Hapus</button>
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
      	$stopword = new Stopword;
      	$stopword->kata = $request->input('kata');

      	if($stopword->save()){
    	  	$response = array(
    	  		'status' => 'OK',
    	  		'message' => 'stopword berhasil ditambahkan'
    	  	);
      	}
      	else{
      		$response = array(
    	  		'status' => 'error',
    	  		'message' => 'stopword gagal ditambahkan'
    	  	);
      	}

      	return response()->json($response);
    }

    public function read(Request $request, $id){
      	$data = Stopword::find($id);
      	return response()->json($data);
    }

    public function update(Request $request, $id){
      	$stopword = Stopword::find($id);
      	$stopword->kata = $request->input('kata');

      	if($stopword->save()){
    	  	$response = array(
    	  		'status' => 'OK',
    	  		'message' => 'stopword berhasil diperbaharui'
    	  	);
      	}
      	else{
      		$response = array(
    	  		'status' => 'error',
    	  		'message' => 'stopword gagal diperbaharui'
    	  	);
      	}

      	return response()->json($response);
    }

    public function delete(Request $request, $id){
      	$stopword = Stopword::find($id);

      	if($stopword->delete()){
      		$response = array(
    	  		'status' => 'OK',
    	  		'message' => 'stopword berhasil dihapus'
    	  	);
      	}
      	else{
      		$response = array(
    	  		'status' => 'error',
    	  		'message' => 'stopword gagal dihapus'
    	  	);
      	}

      	return response()->json($response);
    }
}
