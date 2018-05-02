<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Komentar;

class KomentarController extends Controller
{
    public function __construct(){
        $this->middleware('auth.super');
    }

    public function index(){
  	     return view('komentar');
    }

    public function data(Request $request){
	    $columns = array(

          0 =>'komentar',
          1 =>'jenis_data',
          2 =>'sentimen_awal',
          3 =>'id',

        );

      	$limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        $totalData = Komentar::count();

        if(empty($request->input()))
        {
          $komentars = Komentar::offset($start)
    				->limit($limit)
    				->orderBy($order,$dir)
    				->get();

          $totalFiltered = $totalData;
        }
        else if(!empty($request->input())) {
          if(!empty($request->input('search'))){
            $search = $request->input('search.value');

            $komentars =  Komentar::where('komentar','LIKE',"%{$search}%")
              ->offset($start)
              ->limit($limit)
              ->orderBy($order,$dir)
              ->get();

            $totalFiltered = Komentar::where('komentar','LIKE',"%{$search}%")
              ->count();
          }

          if(!empty($request->input('sentimen'))){
            if($request->input('sentimen')==3){
              $sentimen1=0;
            }
            else {
              $sentimen1 = $request->input('sentimen');
            }

            $komentars =  Komentar::where('sentimen_awal',$sentimen1)
              ->offset($start)
              ->limit($limit)
              ->orderBy($order,$dir)
              ->get();

            $totalFiltered = Komentar::where('sentimen_awal',$sentimen1)
              ->count();
          }

          if(!empty($request->input('jenis_data'))){
            if($request->input('jenis_data')=='belum'){
              $jenisData=3;
            }
            else if($request->input('jenis_data')=='training'){
              $jenisData = 0;
            }
            else if($request->input('jenis_data')=='testing'){
              $jenisData = 1;
            }

            $komentars =  Komentar::where('jenis_data',$jenisData)
              ->offset($start)
              ->limit($limit)
              ->orderBy($order,$dir)
              ->get();

            $totalFiltered = Komentar::where('jenis_data',$jenisData)
              ->count();
          }

          if(!empty($request->input('jenis_data')) AND !empty($request->input('search')) AND empty($request->input('sentimen')) ){
            if($request->input('jenis_data')=='belum'){
              $jenisData=3;
            }
            else if($request->input('jenis_data')=='training'){
              $jenisData = 0;
            }
            else if($request->input('jenis_data')=='testing'){
              $jenisData = 1;
            }
            $search = $request->input('search.value');

            $komentars =  Komentar::where('jenis_data',$jenisData)
              ->where('komentar','LIKE',"%{$search}%")
              ->offset($start)
              ->limit($limit)
              ->orderBy($order,$dir)
              ->get();

            $totalFiltered = Komentar::where('jenis_data',$jenisData)
              ->where('komentar','LIKE',"%{$search}%")
              ->count();
          }

          if(!empty($request->input('jenis_data')) AND empty($request->input('search')) AND !empty($request->input('sentimen')) ){
            if($request->input('jenis_data')=='belum'){
              $jenisData=3;
            }
            else if($request->input('jenis_data')=='training'){
              $jenisData = 0;
            }
            else if($request->input('jenis_data')=='testing'){
              $jenisData = 1;
            }

            if($request->input('sentimen')==3){
              $sentimen1=0;
            }
            else {
              $sentimen1 = $request->input('sentimen');
            }

            $komentars =  Komentar::where('jenis_data',$jenisData)
              ->where('sentimen_awal',$sentimen1)
              ->offset($start)
              ->limit($limit)
              ->orderBy($order,$dir)
              ->get();

            $totalFiltered = Komentar::where('jenis_data',$jenisData)
              ->where('sentimen_awal',$sentimen1)
              ->count();
          }

          if(empty($request->input('jenis_data')) AND !empty($request->input('search')) AND !empty($request->input('sentimen')) ){

            if($request->input('sentimen')==3){
              $sentimen1=0;
            }
            else {
              $sentimen1 = $request->input('sentimen');
            }
            $search = $request->input('search.value');

            $komentars =  Komentar::where('sentimen_awal',$sentimen1)
              ->where('komentar','LIKE',"%{$search}%")
              ->offset($start)
              ->limit($limit)
              ->orderBy($order,$dir)
              ->get();

            $totalFiltered = Komentar::where('sentimen_awal',$sentimen1)
              ->where('komentar','LIKE',"%{$search}%")
              ->count();
          }

          if(!empty($request->input('jenis_data')) AND !empty($request->input('search')) AND !empty($request->input('sentimen')) ){
            if($request->input('jenis_data')=='belum'){
              $jenisData=3;
            }
            else if($request->input('jenis_data')=='training'){
              $jenisData = 0;
            }
            else if($request->input('jenis_data')=='testing'){
              $jenisData = 1;
            }

            if($request->input('sentimen')==3){
              $sentimen1=0;
            }
            else {
              $sentimen1 = $request->input('sentimen');
            }
            $search = $request->input('search.value');

            $komentars =  Komentar::where('jenis_data',$jenisData)
              ->where('sentimen_awal',$sentimen1)
              ->where('komentar','LIKE',"%{$search}%")
              ->offset($start)
              ->limit($limit)
              ->orderBy($order,$dir)
              ->get();

            $totalFiltered = Komentar::where('jenis_data',$jenisData)
              ->where('sentimen_awal',$sentimen1)
              ->where('komentar','LIKE',"%{$search}%")
              ->count();
          }

        }

        $data = array();
        foreach ($komentars as $key=>$komentar)
        {
            $selectData1='';
            $selectData2='';
            $selectData3='';
            $selectAwal1='';
            $selectAwal2='';
            $selectAwal3='';
            if($komentar->jenis_data==0){$selectData1='selected'; $selectData2=''; $selectData3='';}
            else if($komentar->jenis_data==1){$selectData1=''; $selectData2='selected'; $selectData3='';}
            else if($komentar->jenis_data==3){$selectData1=''; $selectData2=''; $selectData3='selected';}

            if($komentar->sentimen_awal==0){$selectAwal1='selected'; $selectAwal2=''; $selectAwal3='';}
            else if($komentar->sentimen_awal==1){$selectAwal1=''; $selectAwal2='selected'; $selectAwal3='';}
            else if($komentar->sentimen_awal==2){$selectAwal1=''; $selectAwal2=''; $selectAwal3='selected';}

            $nestedData['no'] = $start+$key+1;
            $nestedData['komentar'] = $komentar->komentar;
            $nestedData['jenis_data'] = "<select onChange='changeJenisData($komentar->id)' id='selectJenisData-$komentar->id' name='jenis_data' class='form-control' required='true' style='width: 100%;'>
                    <option $selectData1 value='0'>Training</option>
                    <option $selectData2 value='1'>Testing</option>
                    <option $selectData3 value='3'>Belum</option>
                  </select>";
            $nestedData['sentimen_awal'] = "<select onChange='changeSentAwal($komentar->id)' id='selectSentAwal-$komentar->id' name='sentimen_awal' class='form-control' required='true' style='width: 100%;'>
                    <option $selectAwal1 value='0'>Netral</option>
                    <option $selectAwal2 value='1'>Positif</option>
                    <option $selectAwal3 value='2'>Negatif</option>
                  </select>";
            $nestedData['aksi'] = "<div class='btn-group'>
                        <button class='btn btn-danger' onClick='deleteKomentar($komentar->id)'><i class='fa fa-trash'></i>&nbsp&nbsp Hapus</button>
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
      	$komentar = new Komentar;
      	$komentar->kata_singkatan = $request->input('kata_singkatan');
      	$komentar->kata_asli = $request->input('kata_asli');

      	if($komentar->save()){
    	  	$response = array(
    	  		'status' => 'OK',
    	  		'message' => 'komentar berhasil ditambahkan'
    	  	);
      	}
      	else{
      		$response = array(
    	  		'status' => 'error',
    	  		'message' => 'komentar gagal ditambahkan'
    	  	);
      	}

      	return response()->json($response);
    }

    public function read(Request $request, $id){
      	$data = Komentar::find($id);
      	return response()->json($data);
    }

    public function update(Request $request, $id){
      	$komentar = Komentar::find($id);
      	$komentar->kata_singkatan = $request->input('kata_singkatan');
      	$komentar->kata_asli = $request->input('kata_asli');

      	if($komentar->save()){
    	  	$response = array(
    	  		'status' => 'OK',
    	  		'message' => 'komentar berhasil diperbaharui'
    	  	);
      	}
      	else{
      		$response = array(
    	  		'status' => 'error',
    	  		'message' => 'komentar gagal diperbaharui'
    	  	);
      	}

      	return response()->json($response);
    }

    public function updateJenisData(Request $request, $id){
      	$komentar = Komentar::find($id);
      	$komentar->jenis_data = $request->jenis_data;

      	if($komentar->save()){
    	  	$response = array(
    	  		'status' => 'OK',
    	  		'message' => 'Jenis data berhasil diperbaharui'
    	  	);
      	}
      	else{
      		$response = array(
    	  		'status' => 'error',
    	  		'message' => 'Jenis data gagal diperbaharui'
    	  	);
      	}

      	return response()->json($response);
    }

    public function updateSentAwal(Request $request, $id){
      	$komentar = Komentar::find($id);
      	$komentar->sentimen_awal = $request->sentimen_awal;

      	if($komentar->save()){
    	  	$response = array(
    	  		'status' => 'OK',
    	  		'message' => 'Sentimen Awal berhasil diperbaharui'
    	  	);
      	}
      	else{
      		$response = array(
    	  		'status' => 'error',
    	  		'message' => 'Sentimen Awal gagal diperbaharui'
    	  	);
      	}

      	return response()->json($response);
    }

    public function delete(Request $request, $id){
      	$komentar = Komentar::find($id);

      	if($komentar->delete()){
      		$response = array(
    	  		'status' => 'OK',
    	  		'message' => 'komentar berhasil dihapus'
    	  	);
      	}
      	else{
      		$response = array(
    	  		'status' => 'error',
    	  		'message' => 'komentar gagal dihapus'
    	  	);
      	}

      	return response()->json($response);
    }
}
