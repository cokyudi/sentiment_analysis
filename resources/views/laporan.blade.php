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
							<select name="peng_instansi" id="select-instansi" class="form-control" required="true" onchange="barChartData()">
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
								<option value="1" <?=date("m")=='1'?'selected':'';?> >Januari</option>
								<option value="2" <?=date("m")=='2'?'selected':'';?> >Februari</option>
								<option value="3" <?=date("m")=='3'?'selected':'';?> >Maret</option>
								<option value="4" <?=date("m")=='4'?'selected':'';?> >April</option>
								<option value="5" <?=date("m")=='5'?'selected':'';?> >Mei</option>
								<option value="6" <?=date("m")=='6'?'selected':'';?> >Juni</option>
								<option value="7" <?=date("m")=='7'?'selected':'';?> >Juli</option>
								<option value="8" <?=date("m")=='8'?'selected':'';?> >Agustus</option>
								<option value="9" <?=date("m")=='9'?'selected':'';?> >September</option>
								<option value="10" <?=date("m")=='10'?'selected':'';?> >Oktober</option>
								<option value="11" <?=date("m")=='11'?'selected':'';?> >Nopember</option>
								<option value="12" <?=date("m")=='12'?'selected':'';?> >Desember</option>
							</select>
						</div>
					</div>
					<div class="col-sm-5">
						<div class="form-group">
							<label>Tahun</label>
							<select name="tahun" id="select-tahun" class="form-control" required="true">
								<option value="2013" <?=date("Y")=='2013'?'selected':'';?> >2013</option>
								<option value="2014" <?=date("Y")=='2014'?'selected':'';?> >2014</option>
								<option value="2015" <?=date("Y")=='2015'?'selected':'';?> >2015</option>
								<option value="2016" <?=date("Y")=='2016'?'selected':'';?> >2016</option>
								<option value="2017" <?=date("Y")=='2017'?'selected':'';?> >2017</option>
								<option value="2018" <?=date("Y")=='2018'?'selected':'';?> >2018</option>
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



	});
</script>
<script>
    var ctx = document.getElementById("barChart");
    var barChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ["Negatif", "Positif", "Netral"],
            datasets: [{
                    label: 'Sentimen masyarakat',
                    data: [{{$neg1}}, {{$pos1}}, {{$net1}}],
                    backgroundColor: [
                        'rgba(231, 76, 60,1.0)',
                        'rgba(39, 174, 96,1.0)',
                        'rgba(243, 156, 18,1.0)'
                    ],
                    borderColor: [
                        'rgba(231, 76, 60,1.0)',
                        'rgba(39, 174, 96,1.0)',
                        'rgba(243, 156, 18,1.0)'
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

		function barChartData(){
			let url = $('meta[name=url]').prop('content');
			var peng_instansi = $('select[name=peng_instansi]').val();
			var data = {
	        peng_instansi:peng_instansi,
	    }
			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});
			$.ajax({
				url: url+'/laporan/barChartData',
				type: 'post',
				data: data
			})
			.done(function(data) {
				barChart.data.datasets[0].data[0]= data.data.neg1;
				barChart.data.datasets[0].data[1]= data.data.pos1;
				barChart.data.datasets[0].data[2]= data.data.net1;
				barChart.update();
			})
			.fail(function() {
				swal({title: 'Gagal', text: 'Terjadi error dalam pengiriman data', buttonsStyling: false, confirmButtonClass: "btn btn-danger", type: "error"});
			})
		}
</script>
<script>
    var ctx = document.getElementById("donutChart");
    var donutChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ["Negatif", "Positif", "Netral"],
            datasets: [{
                    label: '# of Votes',
                    data: [{{$neg2}}, {{$pos2}}, {{$net2}}],
                    backgroundColor: [
											'rgba(231, 76, 60,1.0)',
											'rgba(39, 174, 96,1.0)',
											'rgba(243, 156, 18,1.0)'
                    ],
                    borderColor: [
											'rgba(231, 76, 60,1.0)',
											'rgba(39, 174, 96,1.0)',
											'rgba(243, 156, 18,1.0)'
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

		$('#select-bulan').change(function() {
			let url = $('meta[name=url]').prop('content');
			var bulan = $('select[name=bulan]').val();
			var tahun = $('select[name=tahun]').val();
			var data = {
	        bulan:bulan,
					tahun:tahun
	    }
			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});
			$.ajax({
				url: url+'/laporan/donutChartData',
				type: 'post',
				data: data
			})
			.done(function(data) {
				donutChart.data.datasets[0].data[0]= data.data.neg2;
				donutChart.data.datasets[0].data[1]= data.data.pos2;
				donutChart.data.datasets[0].data[2]= data.data.net2;
				donutChart.update();
			})
			.fail(function() {
				swal({title: 'Gagal', text: 'Terjadi error dalam pengiriman data', buttonsStyling: false, confirmButtonClass: "btn btn-danger", type: "error"});
			})
		});

		$('#select-tahun').change(function() {
			let url = $('meta[name=url]').prop('content');
			var bulan = $('select[name=bulan]').val();
			var tahun = $('select[name=tahun]').val();
			var data = {
	        bulan:bulan,
					tahun:tahun
	    }
			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});
			$.ajax({
				url: url+'/laporan/donutChartData',
				type: 'post',
				data: data
			})
			.done(function(data) {
				donutChart.data.datasets[0].data[0]= data.data.neg2;
				donutChart.data.datasets[0].data[1]= data.data.pos2;
				donutChart.data.datasets[0].data[2]= data.data.net2;
				donutChart.update();
			})
			.fail(function() {
				swal({title: 'Gagal', text: 'Terjadi error dalam pengiriman data', buttonsStyling: false, confirmButtonClass: "btn btn-danger", type: "error"});
			})
		});

</script>
@endsection
