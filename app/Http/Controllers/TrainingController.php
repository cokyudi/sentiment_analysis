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
            $selectAwal='';
            $classLabel='';

            if($komentar->sentimen_awal==0){$selectAwal='Netral'; $classLabel='label-default';}
            else if($komentar->sentimen_awal==1){$selectAwal='Positif'; $classLabel='label-success';}
            else if($komentar->sentimen_awal==2){$selectAwal='Negatif'; $classLabel='label-danger';}

            $nestedData['no'] = $start+$key+1;
            $nestedData['komentar'] = $komentar->komentar;
            $nestedData['text_prc'] = $komentar->text_prc;
            $nestedData['sentimen_awal'] = "<span class='label $classLabel'>$selectAwal</span>";
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
            $training = strtolower(preg_replace('([.,/123457890@!#$%&-_=+?`~{;:<>}])','',$trainings));
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
            $sentence = implode(' ',array_values(array_unique(array_filter($data2))));
            $output = $stemmer->stem($sentence);
            //simpan hasil preproccessing
            $text_prc = Komentar::find($id);
            $text_prc->text_prc = $output;
            $text_prc->save();

            //$data[] = $output;
        }
        //Seleksi Fitur Chisquare

        $fiturs = Komentar::where('jenis_data','0')->get();
        $v = 0; //jumlah seluruh kata pada data training

        //mencari jumlah sluruh kata pada data training
        foreach ($fiturs as $key => $fitur) {
            $prepros = $fitur->text_prc;
            $ts = explode(' ',$prepros);
            $countTs = count($ts);
            $v = $v + $countTs;
        }

        //mencari jumlah sluruh kata di kelas tertentu pada data training
        $cs = array(); //jumlah seluruh kata untuk satu kelas di data training
        for ($k=0; $k<3 ; $k++) {
            $fiturs2 = Komentar::where('jenis_data','0')->where('sentimen_awal',$k)->get();
            $cs[$k] = 0;
            foreach ($fiturs2 as $key => $fitur2) {
                $prepros2 = $fitur2->text_prc;
                $ts2 = explode(' ',$prepros2);
                $countTs2 = count($ts2);
                $cs[$k] = $cs[$k] + $countTs2;
            }
        }

        foreach ($fiturs as $fitur) {

            $prepros = $fitur->text_prc;
            $ts = explode(' ',$prepros);
            $data3 = array();
            $x = array();
            $hasil = array();
            $ptn=array();
            foreach ($ts as $key=>$t) {
                $cekKata = Pengetahuan::where('kata',$t)->count();

                if($cekKata){
                    continue;
                }
                else{
                    for($k=0;$k<3;$k++){

                        $N = Komentar::where('jenis_data','0')->count(); //seluruh data training
                        $A = Komentar::where('jenis_data','0')->where('sentimen_awal',$k)->where('text_prc','REGEXP','[[:<:]]'.$t.'[[:>:]]')->count(); // data ber kelas $k yg memuat kata $t
                        $B = Komentar::where('jenis_data','0')->where('sentimen_awal','!=', $k)->where('text_prc','REGEXP','[[:<:]]'.$t.'[[:>:]]')->count(); // data selain kelas $k yg memuat kata $t
                        $C = Komentar::where('jenis_data','0')->where('sentimen_awal',$k)->where('text_prc','NOT REGEXP','[[:<:]]'.$t.'[[:>:]]')->count(); // data ber kelas $k yg tidak memuat kata $t
                        $D = Komentar::where('jenis_data','0')->where('sentimen_awal','!=', $k)->where('text_prc','NOT REGEXP','[[:<:]]'.$t.'[[:>:]]')->count(); // data selain kelas $k yg tidak memuat kata $t

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

                        //Chi-square
                        $x[$key][$k] = $penyebut!=0?$pembilang/$penyebut:0;

                        //hitung Probabilitas kata ke-n dengan diketahui kelas $k
                        $pembilang2 = $A + 1;
                        $penyebut2 = $cs[$k] + $v;
                        $ptn[$key][$k] = $penyebut2!=0?$pembilang2/$penyebut2:0;
                    }
                    $hasil[$key] = 0;
                    for ($k=0; $k<3 ; $k++) {
                        $hasil[$key] = $hasil[$key]+$x[$key][$k];
                    }
                    $freqKata = Komentar::where('jenis_data',0)->where('text_prc','REGEXP','[[:<:]]'.$t.'[[:>:]]')->count();

                    $pengetahuan = new Pengetahuan;
                    $pengetahuan->kata = $t;
                    $pengetahuan->frekuensi = $freqKata;
                    $pengetahuan->n_chisquare = $hasil[$key];
                    $pengetahuan->n_netral = $ptn[$key][0];
                    $pengetahuan->n_positif = $ptn[$key][1];
                    $pengetahuan->n_negatif = $ptn[$key][2];
                    $pengetahuan->save();

                    $data3[] = $hasil;
                }
            }
            $data[] = $hasil;
        }

        if($data){
            $response = array(
    	  		'status' => 'OK',
    	  		'message' => 'Training Berhasil'
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
