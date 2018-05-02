<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Komentar;
use App\Pengetahuan;

class DashboardController extends Controller
{
    public function __construct(){
        $this->middleware('auth.admin');
    }

    public function index(){

        $data['dataTraining'] = Komentar::where('jenis_data',0)->count();
        $data['netralAwal'] = Komentar::where('sentimen_awal',0)->where('jenis_data',0)->count();
        $data['positifAwal'] = Komentar::where('sentimen_awal',1)->where('jenis_data',0)->count();
        $data['negatifAwal'] = Komentar::where('sentimen_awal',2)->where('jenis_data',0)->count();

        $data['dataTesting'] = Komentar::where('jenis_data',1)->count();
        $data['netralAkhir'] = Komentar::where('sentimen_akhir',0)->where('jenis_data',1)->count();
        $data['positifAkhir'] = Komentar::where('sentimen_akhir',1)->where('jenis_data',1)->count();
        $data['negatifAkhir'] = Komentar::where('sentimen_akhir',2)->where('jenis_data',1)->count();

        $bulanIni = date("m");
        $tahunIni = date("Y");

        $data['dataBulanIni'] = Komentar::whereMonth('pengtg_tgl','=',$bulanIni)->whereYear('pengtg_tgl','=',$tahunIni)->count();
        $data['bulanIniNet'] = Komentar::where('sentimen_akhir',0)->whereMonth('pengtg_tgl','=',$bulanIni)->whereYear('pengtg_tgl','=',$tahunIni)->count();
        $data['bulanIniPos'] = Komentar::where('sentimen_akhir',1)->whereMonth('pengtg_tgl','=',$bulanIni)->whereYear('pengtg_tgl','=',$tahunIni)->count();
        $data['bulanIniNeg'] = Komentar::where('sentimen_akhir',2)->whereMonth('pengtg_tgl','=',$bulanIni)->whereYear('pengtg_tgl','=',$tahunIni)->count();

        $data['dataTahunIni'] = Komentar::whereYear('pengtg_tgl','=',$tahunIni)->count();
        $data['tahunIniNet'] = Komentar::where('sentimen_akhir',0)->whereYear('pengtg_tgl','=',$tahunIni)->count();
        $data['tahunIniPos'] = Komentar::where('sentimen_akhir',1)->whereYear('pengtg_tgl','=',$tahunIni)->count();
        $data['tahunIniNeg'] = Komentar::where('sentimen_akhir',2)->whereYear('pengtg_tgl','=',$tahunIni)->count();

		    return view('dashboard',$data);
    }
}
