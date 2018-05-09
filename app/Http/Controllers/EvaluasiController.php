<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\LogTesting;

class EvaluasiController extends Controller
{
  public function __construct(){
      $this->middleware('auth.super');
  }

  public function index(){

      $data['tNol'] = LogTesting::where('threshold', '0')->max('akurasi');
      $data['tSatu'] = LogTesting::where('threshold', '1')->max('akurasi');
      $data['tDua'] = LogTesting::where('threshold', '2')->max('akurasi');
      $data['tTiga'] = LogTesting::where('threshold', '3')->max('akurasi');
      $data['tEmpat'] = LogTesting::where('threshold', '4')->max('akurasi');
      $data['tTerbaik'] = max($data['tNol'],$data['tSatu'],$data['tDua'],$data['tTiga'],$data['tEmpat']);

      $data['tNol1'] = LogTesting::where('threshold', '0')->min('waktu_proses');
      $data['tSatu1'] = LogTesting::where('threshold', '1')->min('waktu_proses');
      $data['tDua1'] = LogTesting::where('threshold', '2')->min('waktu_proses');
      $data['tTiga1'] = LogTesting::where('threshold', '3')->min('waktu_proses');
      $data['tEmpat1'] = LogTesting::where('threshold', '4')->min('waktu_proses');
      $data['tTerbaik1'] = min($data['tNol1'],$data['tSatu1'],$data['tDua1'],$data['tTiga1'],$data['tEmpat1']);

      return view('evaluasi',$data);
  }

  public function data(Request $request){
    $columns = array(
        0 =>'threshold',
        1 =>'total_data',
        2 =>'cocok',
        3 =>'waktu_proses',
        4 =>'akurasi',
        5 =>'id'
      );

      $limit = $request->input('length');
      $start = $request->input('start');
      $order = $columns[$request->input('order.0.column')];
      $dir = $request->input('order.0.dir');

      $totalData = LogTesting::count();

      if(empty($request->input('search.value')))
      {
        $logs = LogTesting::offset($start)
          ->limit($limit)
          ->orderBy($order,$dir)
          ->get();

        $totalFiltered = $totalData;
      }
      else {
        $search = $request->input('search.value');

        $logs = LogTesting::where('threshold','LIKE',"%{$search}%")
          ->offset($start)
          ->limit($limit)
          ->orderBy($order,$dir)
          ->get();

        $totalFiltered = LogTesting::where('threshold','LIKE',"%{$search}%")
          ->count();
      }

      $data = array();
      foreach ($logs as $key=>$log)
      {
          $nestedData['no'] = $start+$key+1;
          $nestedData['threshold'] = $log->threshold;
          $nestedData['total_data'] = $log->total_data;
          $nestedData['cocok'] = $log->cocok;
          $nestedData['waktu_proses'] = $log->waktu_proses;
          $nestedData['akurasi'] = $log->akurasi;

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
