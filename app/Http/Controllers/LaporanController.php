<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Instansi;

class LaporanController extends Controller
{
  public function __construct(){
      $this->middleware('auth.admin');
  }

  public function index(){
      $data['instansis']=Instansi::get();
      return view('laporan',$data);
  }
}
