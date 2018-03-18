<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Komentar;
use App\Kamus;
use App\Stopword;

class TrainingController extends Controller
{
    public function __construct(){
        $this->middleware('auth.super');
    }

    public function index(){
  	     return view('training');
    }

    public function data(Request $request){
	    $columns = array(

          0 =>'komentar',
          1 =>'text_prc',
          2 =>'sentimen_awal',
          3 =>'id',

        );

      	$limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        $totalData = Komentar::where('jenis_data','0')->count();

        if(empty($request->input('search.value')))
        {
          $komentars = Komentar::where('jenis_data','0')->offset($start)
    				->limit($limit)
    				->orderBy($order,$dir)
    				->get();

          $totalFiltered = $totalData;
        }
        else {
          $search = $request->input('search.value');

          $komentars =  Komentar::where('jenis_data','0')->where('komentar','LIKE',"%{$search}%")
            ->offset($start)
            ->limit($limit)
            ->orderBy($order,$dir)
            ->get();

          $totalFiltered = Komentar::where('jenis_data','0')->where('komentar','LIKE',"%{$search}%")
            ->count();
        }

        $data = array();
        foreach ($komentars as $key=>$komentar)
        {
            $selectAwal1='';
            $selectAwal2='';
            $selectAwal3='';

            if($komentar->sentimen_awal==0){$selectAwal1='selected'; $selectAwal2=''; $selectAwal3='';}
            else if($komentar->sentimen_awal==1){$selectAwal1=''; $selectAwal2='selected'; $selectAwal3='';}
            else if($komentar->sentimen_awal==2){$selectAwal1=''; $selectAwal2=''; $selectAwal3='selected';}

            $nestedData['no'] = $key+1;
            $nestedData['komentar'] = $komentar->komentar;
            $nestedData['text_prc'] = $komentar->text_prc;
            $nestedData['sentimen_awal'] = "<select disabled onChange='changeSentAwal($komentar->id)' id='selectSentAwal-$komentar->id' name='sentimen_awal' class='form-control' required='true' style='width: 100%;'>
                    <option $selectAwal1 value='0'>Netral</option>
                    <option $selectAwal2 value='1'>Positif</option>
                    <option $selectAwal3 value='2'>Negatif</option>
                  </select>";
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

    public function doTraining(Request $request){

        $komentars = Komentar::where('jenis_data','0')->get();;

        $data = array();
        foreach ($komentars as $komentar)
        {
            $trainings = $komentar->komentar;
            $id = $komentar->id;

            $training = strtolower(preg_replace('([.,/])','',$trainings));
            $training = strtolower(preg_replace('([\n\r])',' ',$training));
            $katass = array_values(array_filter((explode(' ',$training))));

            $data2 = array();
            foreach ($katass as $katas) {
                $kamus = Kamus::select('kata_asli')->where('kata_singkatan',$katas)->first();
                if($kamus){
                    $kata = $kamus->kata_asli;
                }
                else{
                    $kata = $katas;
                }
                $stopword = Stopword::select('kata')->where('kata',$kata)->first();
                if($stopword){
                    $data2[] = '';
                }
                else {
                    $data2[] = $kata;
                }
            }

            $data[] = implode(' ',array_values(array_filter($data2)));
        }

        if($data){
            $response = array(
    	  		'status' => 'OK',
    	  		'message' => $data
    	  	);
        }
        else {
            $response = array(
    	  		'status' => 'error',
    	  		'message' => 'Training gagal'
    	  	);
        }
        return response()->json($response);
    }

}
