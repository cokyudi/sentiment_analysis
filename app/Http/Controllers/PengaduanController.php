<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pengaduan;
use App\Komentar;

class PengaduanController extends Controller
{
    public function __construct(){
        $this->middleware('auth.super');
    }

    public function index(){
  	     return view('pengaduan');
    }

    public function data(Request $request){
	    $columns = array(
          0 =>'peng_topik',
          1 =>'komentar',
          2 =>'pengtg_tgl',
          3 =>'sentimen',
          4 =>'id'
        );

      	$limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        $totalData = Komentar::join('pengaduan','komentar.peng_id','=','pengaduan.id')->count();

        if(empty($request->input('search.value')))
        {
          $komentars = Komentar::selectRaw('komentar.id as idk, pengaduan.id as idp, komentar, pengtg_tgl, sentimen_awal, sentimen_akhir, peng_instansi, peng_topik, jenis_data')
                    ->join('pengaduan','komentar.peng_id','=','pengaduan.id')
                    ->offset($start)
                    ->limit($limit)
    				->orderBy($order,$dir)
    				->get();

          $totalFiltered = $totalData;
        }
        else {
          $search = $request->input('search.value');

          $komentars = Komentar::selectRaw('komentar.id as idk, pengaduan.id as idp, komentar, pengtg_tgl, sentimen_awal, sentimen_akhir, peng_instansi, peng_topik, jenis_data')
            ->join('pengaduan','komentar.peng_id','=','pengaduan.id')
            ->where('peng_topik','LIKE',"%{$search}%")
            ->offset($start)
            ->limit($limit)
            ->orderBy($order,$dir)
            ->get();

          $totalFiltered = Komentar::join('pengaduan','komentar.peng_id','=','pengaduan.id')
            ->where('peng_topik','LIKE',"%{$search}%")
            ->count();
        }

        $data = array();
        foreach ($komentars as $key=>$komentar)
        {
            $selectAwal = '';
            $classLabel = '';
            $sentimen = $komentar->jenis_data==1?$komentar->sentimen_akhir:$komentar->sentimen_awal;
            if($sentimen==0){$selectAwal='Netral'; $classLabel='label-default';}
            else if($sentimen==1){$selectAwal='Positif'; $classLabel='label-success';}
            else if($sentimen==2){$selectAwal='Negatif'; $classLabel='label-danger';}

            $nestedData['no'] = $start+$key+1;
            $nestedData['peng_topik'] = "<b>$komentar->peng_topik</b>";
            $nestedData['komentar'] = $komentar->komentar;
            $nestedData['pengtg_tgl'] = $komentar->pengtg_tgl;
            $nestedData['sentimen'] = "<span class='label $classLabel'>$selectAwal</span>";
            $nestedData['aksi'] = "<button class='btn btn-success' onClick='detailPengaduan($komentar->idp)'><i class='fa fa-pencil'></i>&nbsp&nbsp Detail</button>
                        <button class='btn btn-danger' onClick='deleteKomentar($komentar->idk)'><i class='fa fa-trash'></i>&nbsp&nbsp Hapus</button>";
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

    public function read(Request $request, $id){
      	$data = Pengaduan::join('pengaduan_tindaklanjut','pengaduan.id','=','pengaduan_tindaklanjut.peng_id')->find($id);
      	return response()->json($data);
    }
}
