<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Komentar;
use App\Kamus;
use App\Stopword;
use App\Pengetahuan;
use \Sastrawi\Stemmer\StemmerFactory;

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
        //Text Preprocessing
        $komentars = Komentar::where('jenis_data','0')->get();;

        $data = array();
        foreach ($komentars as $komentar)
        {
            $trainings = $komentar->komentar;
            $id = $komentar->id;
            //Membersihkan Kata
            $training = strtolower(preg_replace('([.,/123457890@])','',$trainings));
            $training = strtolower(preg_replace('([\n\r])',' ',$training));
            //tokenize
            $katass = array_values(array_filter((explode(' ',$training))));
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
            $sentence = implode(' ',array_values(array_filter($data2)));
            $output = $stemmer->stem($sentence);
            //simpan hasil preproccessing
            $text_prc = Komentar::find($id);
            $text_prc->text_prc = $output;
            $text_prc->save();
            //seleksi fitur chi-square

            //$data[] = $output;
        }
        //Seleksi Fitur Chisquare
        $fiturs = Komentar::where('jenis_data','0')->get();

        foreach ($fiturs as $fitur) {

            $prepros = $fitur->text_prc;
            $ts = explode(' ',$prepros);
            $data3 = array();
            $x = array();
            $hasil = array();
            foreach ($ts as $key=>$t) {
                $cekKata = Pengetahuan::where('kata',$t)->count();
                if($cekKata){
                    continue;
                }
                else{
                    // $A=array();
                    for($k=0;$k<3;$k++){
                        $N = Komentar::where('jenis_data','0')->count(); //seluruh data training
                        $A = Komentar::where('jenis_data','0')->where('sentimen_awal',$k)->where('text_prc','LIKE',"%$t%")->count(); // data ber kelas $k yg memuat kata $t
                        $B = Komentar::where('jenis_data','0')->where('sentimen_awal','!=', $k)->where('text_prc','LIKE',"%$t%")->count(); // data selain kelas $k yg memuat kata $t
                        $C = Komentar::where('jenis_data','0')->where('sentimen_awal',$k)->where('text_prc','NOT LIKE',"%$t%")->count(); // data ber kelas $k yg tidak memuat kata $t
                        $D = Komentar::where('jenis_data','0')->where('sentimen_awal','!=', $k)->where('text_prc','NOT LIKE',"%$t%")->count(); // data selain kelas $k yg tidak memuat kata $t

                        $AD = $A*$D;
                        $BC = $B*$C;
                        $AC = $A+$C;
                        $BD = $B+$D;
                        $AB = $A+$B;
                        $CD = $C+$D;

                        //pembilang
                        $ADBC = $AD-$BC;
                        $ADBC2 = $ADBC*$ADBC;
                        $pembilang = $N*$ADBC2;

                        //penyebut
                        $penyebut = $AC*$BD*$AB*$CD;

                        $x[$key][$k] = $pembilang/$penyebut;
                    }
                    $hasil[$key] = 0;
                    for ($k=0; $k<3 ; $k++) {
                        $hasil[$key] = $hasil[$key]+$x[$key][$k];
                    }
                    $pengetahuan = new Pengetahuan;
                    $pengetahuan->kata = $t;
                    $pengetahuan->nilai = $hasil[$key];
                    $pengetahuan->save();

                    $data3[] = $hasil;
                }
            }
            $data[] = $hasil;
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
