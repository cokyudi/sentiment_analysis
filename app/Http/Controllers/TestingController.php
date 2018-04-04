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
          3 =>'sentimen_akhir',
          4 =>'id',

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

            $selectAkhir1='';
            $selectAkhir2='';
            $selectAkhir3='';

            if($komentar->sentimen_awal==0){$selectAwal1='selected'; $selectAwal2=''; $selectAwal3='';}
            else if($komentar->sentimen_awal==1){$selectAwal1=''; $selectAwal2='selected'; $selectAwal3='';}
            else if($komentar->sentimen_awal==2){$selectAwal1=''; $selectAwal2=''; $selectAwal3='selected';}

            if($komentar->sentimen_akhir==0){$selectAkhir1='selected'; $selectAkhir2=''; $selectAkhir3='';}
            else if($komentar->sentimen_akhir==1){$selectAkhir1=''; $selectAkhir2='selected'; $selectAkhir3='';}
            else if($komentar->sentimen_akhir==2){$selectAkhir1=''; $selectAkhir2=''; $selectAkhir3='selected';}

            $nestedData['no'] = $key+1;
            $nestedData['komentar'] = $komentar->komentar;
            $nestedData['text_prc'] = $komentar->text_prc;
            $nestedData['sentimen_awal'] = "<select disabled onChange='changeSentAwal($komentar->id)' id='selectSentAwal-$komentar->id' name='sentimen_awal' class='form-control' required='true' style='width: 100%;'>
                    <option $selectAwal1 value='0'>Netral</option>
                    <option $selectAwal2 value='1'>Positif</option>
                    <option $selectAwal3 value='2'>Negatif</option>
                    </select>";
            $nestedData['sentimen_akhir'] = "<select disabled name='sentimen_akhir' class='form-control' required='true' style='width: 100%;'>
                    <option $selectAkhir1 value='0'>Netral</option>
                    <option $selectAkhir2 value='1'>Positif</option>
                    <option $selectAkhir3 value='2'>Negatif</option>
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

    public function doTesting(Request $request)
    {
        //Text Preprocessing
        $komentars = Komentar::where('jenis_data','1')->get();
        $n = Komentar::where('jenis_data','0')->count();

        $data = array();
        foreach ($komentars as $komentar)
        {
            $testings = $komentar->komentar;
            $id = $komentar->id;
            //Membersihkan Kata
            $testing = strtolower(preg_replace('([.,/123457890@])','',$testings));
            $testing = strtolower(preg_replace('([\n\r])',' ',$testing));
            //tokenize
            $katass = array_values(array_filter((explode(' ',$testing))));
            //pengembalian kata (kamus,kata singkatan)
            $data2 = array();
            foreach ($katass as $katas) {
                $kamus = Kamus::select('kata_asli')->where('kata_singkatan',$katas)->first();
                if($kamus){
                    $kata = $kamus->kata_asli;
                }
                else{
                    $kata = $katas;
                }
                //menghilangkan stopword
                $stopword = Stopword::select('kata')->where('kata',$kata)->first();
                if($stopword){
                    $data2[] = '';
                }
                else {
                    $data2[] = $kata;
                }
            }
            //stemming
            $stemmerFactory = new \Sastrawi\Stemmer\StemmerFactory;
            $stemmer  = $stemmerFactory->createStemmer();
            $sentence = implode(' ',array_values(array_unique(array_filter($data2))));
            $output = $stemmer->stem($sentence);
            //simpan hasil preproccessing
            $text_prc = Komentar::find($id);
            $text_prc->text_prc = $output;
            $text_prc->save();
            //$data[] = $text_prc;
        }

        $data2 = array();
        //Algoritma Boolean Multinomial Naive Bayes
        $fiturs = Komentar::where('jenis_data','1')->get();
        $threshold = $request->input('threshold');

        foreach ($fiturs as $key => $fitur) {

            $id = $fitur->id;

            $prepros = $fitur->text_prc;
            $ts = explode(' ',$prepros);

            $probKomentar = array();
            $probKata = array();
            $probKatas = array();
            for ($k=0; $k<3 ; $k++) {

                $nc = Komentar::where('jenis_data','0')->where('sentimen_awal',$k)->count();
                $prior = $nc/$n;
                $probKatas[$k] = 1;
                foreach ($ts as $key2 => $t) {
                    $pengetahuan = Pengetahuan::where('kata',$t)->first();

                    if($pengetahuan){
                        $chisquare = $pengetahuan->n_chisquare;
                    }

                    if($pengetahuan AND $chisquare>=$threshold){
                        if($k==0){
                            $probKata[0][$key2] = $pengetahuan->n_netral;
                        }
                        else if ($k==1) {
                            $probKata[1][$key2] = $pengetahuan->n_positif;
                        }
                        else if ($k==2) {
                            $probKata[2][$key2] = $pengetahuan->n_negatif;
                        }
                    }
                    else {
                        $probKata[$k][$key2] = 1;
                    }

                    $probKatas[$k]=$probKatas[$k]*$probKata[$k][$key2];
                }
                $probKomentar[$k]=$prior*$probKatas[$k];
            }
            $data2[$key] = $probKomentar;
            $updateAkhir = Komentar::find($id);
            $updateAkhir->sentimen_akhir = array_search(max($probKomentar),$probKomentar);
            $updateAkhir->save();
        }
        $data[] = $data2;

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
