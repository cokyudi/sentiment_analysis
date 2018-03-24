<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Komentar;
use App\Kamus;
use App\Stopword;
use App\Pengetahuan;
use \Sastrawi\Stemmer\StemmerFactory;

class TestingController extends Controller
{
    public function __construct(){
        $this->middleware('auth.super');
    }

    public function index(){
  	     return view('testing');
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

        $totalData = Komentar::where('jenis_data','1')->count();

        if(empty($request->input('search.value')))
        {
          $komentars = Komentar::where('jenis_data','1')->offset($start)
    				->limit($limit)
    				->orderBy($order,$dir)
    				->get();

          $totalFiltered = $totalData;
        }
        else {
          $search = $request->input('search.value');

          $komentars =  Komentar::where('jenis_data','1')->where('komentar','LIKE',"%{$search}%")
            ->offset($start)
            ->limit($limit)
            ->orderBy($order,$dir)
            ->get();

          $totalFiltered = Komentar::where('jenis_data','1')->where('komentar','LIKE',"%{$search}%")
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
}
