<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Komentar;

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

		return view('dashboard',$data);
    }
}
