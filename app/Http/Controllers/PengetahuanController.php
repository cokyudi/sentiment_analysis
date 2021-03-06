<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pengetahuan;

class PengetahuanController extends Controller
{
    public function __construct(){
        $this->middleware('auth.super');
    }

    public function index(){
  	     return view('pengetahuan');
    }

    public function data(Request $request){
	    $columns = array(
          0 =>'id',
          1 =>'kata',
          2 =>'frekuensi',
          3 =>'n_chisquare',
          4 =>'n_netral',
          5 =>'n_positif',
          6 =>'n_negatif',
        );

      	$limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        $totalData = Pengetahuan::count();

        if(empty($request->input('search.value')))
        {
          $pengetahuans = Pengetahuan::offset($start)
    				->limit($limit)
    				->orderBy($order,$dir)
    				->get();

          $totalFiltered = $totalData;
        }
        else {
          $search = $request->input('search.value');

          $pengetahuans =  Pengetahuan::where('kata','LIKE',"%{$search}%")
            ->offset($start)
            ->limit($limit)
            ->orderBy($order,$dir)
            ->get();

          $totalFiltered = Pengetahuan::where('kata','LIKE',"%{$search}%")
            ->count();
        }

        $data = array();
        foreach ($pengetahuans as $key=>$pengetahuan)
        {
            $nestedData['no'] = $start+$key+1;
            $nestedData['kata'] = $pengetahuan->kata;
            $nestedData['frekuensi'] = $pengetahuan->frekuensi;
            $nestedData['n_chisquare'] = $pengetahuan->n_chisquare;
            $nestedData['n_netral'] = $pengetahuan->n_netral;
            $nestedData['n_positif'] = $pengetahuan->n_positif;
            $nestedData['n_negatif'] = $pengetahuan->n_negatif;
            $nestedData['aksi'] = "<div class='btn-group'>
    					<button class='btn btn-success' onClick='editPengetahuan($pengetahuan->id)'><i class='fa fa-pencil'></i>&nbsp&nbsp Ubah</button>
                        <button class='btn btn-danger' onClick='deletePengetahuan($pengetahuan->id)'><i class='fa fa-trash'></i>&nbsp&nbsp Hapus</button>
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
      	$pengetahuan = new Pengetahuan;
      	$pengetahuan->kata = $request->input('kata');
        $pengetahuan->frekuensi = $request->input('frekuensi');
        $pengetahuan->n_chisquare = $request->input('n_chisquare');
        $pengetahuan->n_netral = $request->input('n_netral');
        $pengetahuan->n_positif = $request->input('n_positif');
        $pengetahuan->n_negatif = $request->input('n_negatif');

      	if($pengetahuan->save()){
    	  	$response = array(
    	  		'status' => 'OK',
    	  		'message' => 'pengetahuan berhasil ditambahkan'
    	  	);
      	}
      	else{
      		$response = array(
    	  		'status' => 'error',
    	  		'message' => 'pengetahuan gagal ditambahkan'
    	  	);
      	}

      	return response()->json($response);
    }

    public function read(Request $request, $id){
      	$data = Pengetahuan::find($id);
      	return response()->json($data);
    }

    public function update(Request $request, $id){
      	$pengetahuan = Pengetahuan::find($id);
      	$pengetahuan->kata = $request->input('kata');
        $pengetahuan->frekuensi = $request->input('frekuensi');
        $pengetahuan->n_chisquare = $request->input('n_chisquare');
        $pengetahuan->n_netral = $request->input('n_netral');
        $pengetahuan->n_positif = $request->input('n_positif');
        $pengetahuan->n_negatif = $request->input('n_negatif');

      	if($pengetahuan->save()){
    	  	$response = array(
    	  		'status' => 'OK',
    	  		'message' => 'pengetahuan berhasil diperbaharui'
    	  	);
      	}
      	else{
      		$response = array(
    	  		'status' => 'error',
    	  		'message' => 'pengetahuan gagal diperbaharui'
    	  	);
      	}

      	return response()->json($response);
    }

    public function delete(Request $request, $id){
      	$pengetahuan = Pengetahuan::find($id);

      	if($pengetahuan->delete()){
      		$response = array(
    	  		'status' => 'OK',
    	  		'message' => 'pengetahuan berhasil dihapus'
    	  	);
      	}
      	else{
      		$response = array(
    	  		'status' => 'error',
    	  		'message' => 'pengetahuan gagal dihapus'
    	  	);
      	}

      	return response()->json($response);
    }
}
