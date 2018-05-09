<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Komentar;
use App\Kamus;
use App\Stopword;
use App\Pengetahuan;
use App\LogTesting;
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
            $selectAwal='';
            $classLabel1='';

            $selectAkhir='';
            $classLabel2='';

            if($komentar->sentimen_awal==0){$selectAwal='Netral'; $classLabel1='label-default';}
            else if($komentar->sentimen_awal==1){$selectAwal='Positif'; $classLabel1='label-success';}
            else if($komentar->sentimen_awal==2){$selectAwal='Negatif'; $classLabel1='label-danger';}

            if($komentar->sentimen_akhir==0){$selectAkhir='Netral'; $classLabel2='label-default';}
            else if($komentar->sentimen_akhir==1){$selectAkhir='Positif'; $classLabel2='label-success';}
            else if($komentar->sentimen_akhir==2){$selectAkhir='Negatif'; $classLabel2='label-danger';}

            $nestedData['no'] = $start+$key+1;
            $nestedData['komentar'] = $komentar->komentar;
            $nestedData['text_prc'] = $komentar->text_prc;
            $nestedData['sentimen_awal'] = "<span class='label $classLabel1'>$selectAwal</span>";
            $nestedData['sentimen_akhir'] = "<span class='label $classLabel2'>$selectAkhir</span>";
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
        $time_start = microtime(true);
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
        $cocok = 0;
        foreach ($fiturs as $key => $fitur) {

            $id = $fitur->id;
            $awal = $fitur->sentimen_awal;

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

            if($awal==array_search(max($probKomentar),$probKomentar)){
              $cocok++;
            }
        }
        $data[] = $data2;
        $time_end = microtime(true);
        $exeTime = $time_end - $time_start;

        $logTesting = new LogTesting;
        $logTesting->threshold = $threshold;
        $logTesting->total_data = count($fiturs);
        $logTesting->cocok = $cocok;
        $logTesting->akurasi = ($cocok/count($fiturs))*100;
        $logTesting->waktu_proses = $exeTime;
        $logTesting->tgl_log = date("Y-m-d H:i:s");
        $logTesting->save();

        if($data){
            $response = array(
    	  		'status' => 'OK',
    	  		'message' => 'Testing Berhasil'
    	  	);
        }
        else {
            $response = array(
    	  		'status' => 'error',
    	  		'message' => 'Testing gagal'
    	  	);
        }
        return response()->json($response);
    }

    public function doOneTesting(Request $request){

        $time_start = microtime(true);

        $testings = $request->input('komentar');
        $n = Komentar::where('jenis_data','0')->count();
        $threshold = $request->input('threshold');

        //$data = array();
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

        $prepros = $output;
        $ts = explode(' ',$prepros);
        $jumKata = 0;
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
                    $jumKata++;
                }
                else {
                    $probKata[$k][$key2] = 1;
                }

                $probKatas[$k]=$probKatas[$k]*$probKata[$k][$key2];
            }
            $probKomentar[$k]=$prior*$probKatas[$k];
        }
        $data = array_search(max($probKomentar),$probKomentar);
        $time_end = microtime(true);
        $exeTime = $time_end - $time_start;

        if(isset($data)){
            if($data==0){
              $hasil = "<span class='label label-default'>Netral</span>";
              $btn = "btn btn-warning";
              $tipe = "warning";
            }
            else if($data==1){
              $hasil = "<span class='label label-success'>Positif</span>";
              $btn = "btn btn-success";
              $tipe = "success";
            }
            else if($data==2){
              $hasil = "<span class='label label-danger'>Negatif</span>";
              $btn = "btn btn-danger";
              $tipe = "error";
            }

            $response = array(
    	  		'status' => 'OK',
    	  		'message' => $testings,
            'hasil' => $hasil,
            'btn' => $btn,
            'tipe' => $tipe,
            'threshold' => $threshold,
            'hasil_text_prc' => $output,
            'jumlah kata' => $jumKata/3,
            'prob_netral' => $probKomentar[0],
            'prob_positif' => $probKomentar[1],
            'prob_negatif' => $probKomentar[2],
    	  	);
        }
        else {
            $response = array(
    	  		'status' => 'error',
    	  		'message' => 'Testing gagal'
    	  	);
        }
        return response()->json($response);
    }
}
