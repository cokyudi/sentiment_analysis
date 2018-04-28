<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Instansi;
use App\Komentar;

class LaporanController extends Controller
{
  public function __construct(){
      $this->middleware('auth.admin');
  }

  public function index(){
      $data['instansis']=Instansi::get();
      $data['neg1']=Komentar::join('pengaduan','komentar.peng_id','=','pengaduan.id')
                            ->where('peng_instansi','Badan Kepegawaian Dan Pengembangan Sumber Daya Manusia Kota Denpasar')
                            ->where('sentimen_awal',2)
                            ->count();
      $data['pos1']=Komentar::join('pengaduan','komentar.peng_id','=','pengaduan.id')
                            ->where('peng_instansi','Badan Kepegawaian Dan Pengembangan Sumber Daya Manusia Kota Denpasar')
                            ->where('sentimen_awal',1)
                            ->count();
      $data['net1']=Komentar::join('pengaduan','komentar.peng_id','=','pengaduan.id')
                            ->where('peng_instansi','Badan Kepegawaian Dan Pengembangan Sumber Daya Manusia Kota Denpasar')
                            ->where('sentimen_awal',0)
                            ->count();

      $thisMonth = date("m");
      $thisYear = date("Y");

      $data['neg2']=Komentar::where('sentimen_awal',2)->whereMonth('pengtg_tgl','=',$thisMonth)->whereYear('pengtg_tgl','=',$thisYear)->count();
      $data['pos2']=Komentar::where('sentimen_awal',1)->whereMonth('pengtg_tgl','=',$thisMonth)->whereYear('pengtg_tgl','=',$thisYear)->count();
      $data['net2']=Komentar::where('sentimen_awal',0)->whereMonth('pengtg_tgl','=',$thisMonth)->whereYear('pengtg_tgl','=',$thisYear)->count();

      return view('laporan',$data);
  }

  public function barChartData(Request $request){
      $peng_instansi = $request->input('peng_instansi');

      $nestedData['neg1'] = Komentar::join('pengaduan','komentar.peng_id','=','pengaduan.id')
                            ->where('peng_instansi',$peng_instansi)
                            ->where('sentimen_awal',2)
                            ->count();
      $nestedData['pos1'] = Komentar::join('pengaduan','komentar.peng_id','=','pengaduan.id')
                            ->where('peng_instansi',$peng_instansi)
                            ->where('sentimen_awal',1)
                            ->count();
      $nestedData['net1'] = Komentar::join('pengaduan','komentar.peng_id','=','pengaduan.id')
                            ->where('peng_instansi',$peng_instansi)
                            ->where('sentimen_awal',0)
                            ->count();

      $response = array(
        "data"            => $nestedData
      );

      return response()->json($response);
  }

  public function donutChartData(Request $request){
      $bulan = $request->input('bulan');
      $tahun = $request->input('tahun');

      $nestedData['neg2'] = Komentar::where('sentimen_awal',2)->whereMonth('pengtg_tgl','=',$bulan)->whereYear('pengtg_tgl','=',$tahun)->count();
      $nestedData['pos2'] = Komentar::where('sentimen_awal',1)->whereMonth('pengtg_tgl','=',$bulan)->whereYear('pengtg_tgl','=',$tahun)->count();
      $nestedData['net2'] = Komentar::where('sentimen_awal',0)->whereMonth('pengtg_tgl','=',$bulan)->whereYear('pengtg_tgl','=',$tahun)->count();

      $response = array(
        "data"            => $nestedData
      );

      return response()->json($response);
  }
}
