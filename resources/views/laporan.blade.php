@extends('master')

@section('title', config('app.name').' | Laporan')
@section('header', 'Laporan')

@section('content')
<div class="row">
	<div class="col-md-6 col-xs-12">

	  <div class="box box-danger">
	    <div class="box-header">
	      <h3 class="box-title">Laporan</h3>
	    </div>
	    <!-- /.box-header -->
	    <div class="box-body">
				<div class="row">
					<div class="col-sm-5">
						<div class="form-group">
							<label>Instansi</label>
							<select name="peng_instansi" id="select-instansi" class="form-control" required="true">
					<?php foreach($instansis as $instansi){?>
								<option value="<?=$instansi->nama_instansi?>"><?=$instansi->nama_instansi?></option>
					<?php } ?>
							</select>
						</div>
					</div>
				</div>
          <canvas id="barChart"></canvas>
	    </div>
	    <!-- /.box-body -->
	  </div>
	  <!-- /.box -->
	</div>
	<!-- /.col -->
	<div class="col-md-6 col-xs-12">

	  <div class="box box-danger">
	    <div class="box-header">
	      <h3 class="box-title">Laporan</h3>
	    </div>
	    <!-- /.box-header -->
	    <div class="box-body">
				<div class="row">
					<div class="col-sm-5">
						<div class="form-group">
							<label>Bulan</label>
							<select name="bulan" id="select-bulan" class="form-control" required="true">
								<option value="1">Januari</option>
								<option value="2">Februari</option>
								<option value="3">Maret</option>
								<option value="4">April</option>
								<option value="5">Mei</option>
								<option value="6">Juni</option>
								<option value="7">Juli</option>
								<option value="8">Agustus</option>
								<option value="9">September</option>
								<option value="10">Oktober</option>
								<option value="11">Nopember</option>
								<option value="12">Desember</option>
							</select>
						</div>
					</div>
				</div>
          <canvas id="donutChart"></canvas>
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
	// var dataTableEvaluasi;
	$(document).ready(function() {
		// Aktifkan menu sidebar
		$('#menu-laporan').addClass('active');

		// dataTableEvaluasi = $('#table-evaluasi').DataTable({
	  //     "processing": true,
	  //     "serverSide": true,
	  //     "ajax":{
		// 		"url": "{{ URL('evaluasi/data') }}",
		// 		"dataType": "json",
		// 		"type": "POST",
		// 		"data":{ _token: "{{csrf_token()}}"}
	  //     },
	  //     "columns": [
	  //         { "data": "no" },
	  //         { "data": "threshold" },
    //         { "data": "total_data" },
    //         { "data": "cocok" },
    //         { "data": "tgl_log" },
    //         { "data": "akurasi" }
	  //     ],
	  //     "order": [[3, "desc"]]
	  // 	});

	});
</script>
<script>
    var ctx = document.getElementById("barChart");
    var barChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ["Negatif", "Positif", "Netral"],
            datasets: [{
                    label: '# of Votes',
                    data: [12, 19, 3],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255,99,132,1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
        },
        options: {
            scales: {
                yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
            }
        }
    });
</script>
<script>
    var ctx = document.getElementById("donutChart");
    var donutChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ["Negatif", "Positif", "Netral"],
            datasets: [{
                    label: '# of Votes',
                    data: [12, 19, 3],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255,99,132,1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
        },
        options: {
            scales: {
                yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
            }
        }
    });
</script>
@endsection
