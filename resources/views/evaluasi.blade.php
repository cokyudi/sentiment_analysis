@extends('master')

@section('title', config('app.name').' | evaluasi')
@section('header', 'evaluasi')

@section('content')
<div class="row">
	<div class="col-xs-12">

	  <div class="box box-danger">
	    <div class="box-header">
	      <h3 class="box-title">Akurasi</h3>
	    </div>
	    <!-- /.box-header -->
	    <div class="box-body">
			<div class="row">
		        <div class="col-lg-2 col-xs-12">
		          <!-- small box -->
		          <div class="small-box bg-aqua">
		            <div class="inner">
		              <h3><?=$tNol;?>%</h3>

		              <p>Threshold 0</p>
		            </div>
		          </div>
		        </div>
		        <!-- ./col -->
		        <div class="col-lg-2 col-xs-12">
		          <!-- small box -->
		          <div class="small-box bg-green">
		            <div class="inner">
		              <h3><?=$tSatu;?>%</h3>

		              <p>Threshold 1</p>
		            </div>
		          </div>
		        </div>
		        <!-- ./col -->
		        <div class="col-lg-2 col-xs-12">
		          <!-- small box -->
		          <div class="small-box bg-yellow">
		            <div class="inner">
		              <h3><?=$tDua;?>%</h3>

		              <p>Threshold 2</p>
		            </div>
		          </div>
		        </div>
		        <!-- ./col -->
		        <div class="col-lg-2 col-xs-12">
		          <!-- small box -->
		          <div class="small-box bg-red">
		            <div class="inner">
		              <h3><?=$tTiga;?>%</h3>

		              <p>Threshold 3</p>
		            </div>
		          </div>
		        </div>
		        <!-- ./col -->
						<div class="col-lg-2 col-xs-12">
		          <!-- small box -->
		          <div class="small-box bg-blue">
		            <div class="inner">
		              <h3><?=$tEmpat;?>%</h3>

		              <p>Threshold 4</p>
		            </div>
		          </div>
		        </div>
		        <!-- ./col -->
						<div class="col-lg-2 col-xs-12">
		          <!-- small box -->
		          <div class="small-box bg-purple">
		            <div class="inner">
		              <h3><?=$tTerbaik;?>%</h3>

		              <p>Terbaik</p>
		            </div>
		          </div>
		        </div>
		        <!-- ./col -->
		    </div>
	    </div>
	    <!-- /.box-body -->
	  </div>
	  <!-- /.box -->
	</div>
	<!-- /.col -->
</div>
<!-- /.row -->
<div class="row">
	<div class="col-xs-12">

	  <div class="box box-danger">
	    <div class="box-header">
	      <h3 class="box-title">Waktu Proses</h3>
	    </div>
	    <!-- /.box-header -->
	    <div class="box-body">
			<div class="row">
		        <div class="col-lg-2 col-xs-12">
		          <!-- small box -->
		          <div class="small-box bg-aqua">
		            <div class="inner">
		              <h3><?=$tNol1;?></h3>

		              <p>Threshold 0</p>
		            </div>
		          </div>
		        </div>
		        <!-- ./col -->
		        <div class="col-lg-2 col-xs-12">
		          <!-- small box -->
		          <div class="small-box bg-green">
		            <div class="inner">
		              <h3><?=$tSatu1;?>%</h3>

		              <p>Threshold 1</p>
		            </div>
		          </div>
		        </div>
		        <!-- ./col -->
		        <div class="col-lg-2 col-xs-12">
		          <!-- small box -->
		          <div class="small-box bg-yellow">
		            <div class="inner">
		              <h3><?=$tDua1;?>%</h3>

		              <p>Threshold 2</p>
		            </div>
		          </div>
		        </div>
		        <!-- ./col -->
		        <div class="col-lg-2 col-xs-12">
		          <!-- small box -->
		          <div class="small-box bg-red">
		            <div class="inner">
		              <h3><?=$tTiga1;?>%</h3>

		              <p>Threshold 3</p>
		            </div>
		          </div>
		        </div>
		        <!-- ./col -->
						<div class="col-lg-2 col-xs-12">
		          <!-- small box -->
		          <div class="small-box bg-blue">
		            <div class="inner">
		              <h3><?=$tEmpat1;?>%</h3>

		              <p>Threshold 4</p>
		            </div>
		          </div>
		        </div>
		        <!-- ./col -->
						<div class="col-lg-2 col-xs-12">
		          <!-- small box -->
		          <div class="small-box bg-purple">
		            <div class="inner">
		              <h3><?=$tTerbaik1;?>%</h3>

		              <p>Terbaik</p>
		            </div>
		          </div>
		        </div>
		        <!-- ./col -->
		    </div>
	    </div>
	    <!-- /.box-body -->
	  </div>
	  <!-- /.box -->
	</div>
	<!-- /.col -->
</div>
<!-- /.row -->
<div class="row">
	<div class="col-xs-12">

	  <div class="box box-danger">
	    <div class="box-header">
	      <h3 class="box-title">Evaluasi</h3>
	    </div>
	    <!-- /.box-header -->
	    <div class="box-body table-responsive">
	      <table id="table-evaluasi" class="table table-bordered table-striped">
	        <thead class="red">
  	        <tr>
                  <th>No.</th>
  	        			<th>Threshold</th>
                  <th>Total Data</th>
                  <th>Cocok</th>
                  <th>Waktu Proses</th>
                  <th>Akurasi</th>
  	        </tr>
	        </thead>
	        <tbody>

	        </tbody>
	        <tfoot>
  	        <tr>
                  <th>No.</th>
                  <th>Threshold</th>
                  <th>Total Data</th>
                  <th>Cocok</th>
                  <th>Waktu Proses</th>
                  <th>Akurasi</th>
  	        </tr>
	        </tfoot>
	      </table>
	    </div>
	    <!-- /.box-body -->
	  </div>
	  <!-- /.box -->
	</div>
	<!-- /.col -->
</div>
<!-- /.row -->

<!-- @include('modal/modal-evaluasi')
@include('modal/modal-evaluasi2') -->

@endsection

@section('script')
<!-- <script src="{{URL('public')}}/js/evaluasi.js"></script>
<script src="{{URL('public')}}/js/evaluasi2.js"></script> -->
<script>
	var dataTableEvaluasi;
	$(document).ready(function() {
		// Aktifkan menu sidebar
		$('#menu-evaluasi').addClass('active');

		dataTableEvaluasi = $('#table-evaluasi').DataTable({
	      "processing": true,
	      "serverSide": true,
	      "ajax":{
				"url": "{{ URL('evaluasi/data') }}",
				"dataType": "json",
				"type": "POST",
				"data":{ _token: "{{csrf_token()}}"}
	      },
	      "columns": [
	          { "data": "no" },
	          { "data": "threshold" },
            { "data": "total_data" },
            { "data": "cocok" },
            { "data": "waktu_proses" },
            { "data": "akurasi" }
	      ],
	      "order": [[0, "asc"]]
	  	});

	});
</script>
@endsection
