@extends('master')

@section('title', config('app.name').' | Dashboard')
@section('header', 'Dashboard')

@section('content')
@if(session()->get('admin')['level'] == 1)
<div class="row">
	<div class="col-xs-12 col-md-6">

	  <div class="box box-danger">
	    <div class="box-header">
	      <h3 class="box-title">Data Training</h3>
	    </div>
	    <!-- /.box-header -->
	    <div class="box-body">
			<div class="row">
		        <div class="col-lg-3 col-xs-6">
		          <!-- small box -->
		          <div class="small-box bg-aqua">
		            <div class="inner">
		              <h3><?=$dataTraining?></h3>

		              <p>Komentar</p>
		            </div>
		            <div class="icon">
		              <i class="fa fa-commenting"></i>
		            </div>
		            <a href="#" class="small-box-footer">
		              More info <i class="fa fa-arrow-circle-right"></i>
		            </a>
		          </div>
		        </div>
		        <!-- ./col -->
		        <div class="col-lg-3 col-xs-6">
		          <!-- small box -->
		          <div class="small-box bg-green">
		            <div class="inner">
		              <h3><?=$positifAwal?></h3>

		              <p>Positif</p>
		            </div>
		            <div class="icon">
		              <i class="ion ion-happy"></i>
		            </div>
		            <a href="#" class="small-box-footer">
		              More info <i class="fa fa-arrow-circle-right"></i>
		            </a>
		          </div>
		        </div>
		        <!-- ./col -->
		        <div class="col-lg-3 col-xs-6">
		          <!-- small box -->
		          <div class="small-box bg-yellow">
		            <div class="inner">
		              <h3><?=$netralAwal?></h3>

		              <p>Netral</p>
		            </div>
		            <div class="icon">
		              <i class="fa fa-question-circle"></i>
		            </div>
		            <a href="#" class="small-box-footer">
		              More info <i class="fa fa-arrow-circle-right"></i>
		            </a>
		          </div>
		        </div>
		        <!-- ./col -->
		        <div class="col-lg-3 col-xs-6">
		          <!-- small box -->
		          <div class="small-box bg-red">
		            <div class="inner">
		              <h3><?=$negatifAwal?></h3>

		              <p>Negatif</p>
		            </div>
		            <div class="icon">
		              <i class="ion ion-sad"></i>
		            </div>
		            <a href="#" class="small-box-footer">
		              More info <i class="fa fa-arrow-circle-right"></i>
		            </a>
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

	<div class="col-xs-12 col-md-6">

	  <div class="box box-danger">
	    <div class="box-header">
	      <h3 class="box-title">Data Testing</h3>
	    </div>
	    <!-- /.box-header -->
	    <div class="box-body">
			<div class="row">
		        <div class="col-lg-3 col-xs-6">
		          <!-- small box -->
		          <div class="small-box bg-aqua">
		            <div class="inner">
		              <h3><?=$dataTesting?></h3>

		              <p>Komentar</p>
		            </div>
		            <div class="icon">
		              <i class="fa fa-commenting"></i>
		            </div>
		            <a href="#" class="small-box-footer">
		              More info <i class="fa fa-arrow-circle-right"></i>
		            </a>
		          </div>
		        </div>
		        <!-- ./col -->
		        <div class="col-lg-3 col-xs-6">
		          <!-- small box -->
		          <div class="small-box bg-green">
		            <div class="inner">
		              <h3><?=$positifAkhir?></h3>

		              <p>Positif</p>
		            </div>
		            <div class="icon">
		              <i class="ion ion-happy"></i>
		            </div>
		            <a href="#" class="small-box-footer">
		              More info <i class="fa fa-arrow-circle-right"></i>
		            </a>
		          </div>
		        </div>
		        <!-- ./col -->
		        <div class="col-lg-3 col-xs-6">
		          <!-- small box -->
		          <div class="small-box bg-yellow">
		            <div class="inner">
		              <h3><?=$netralAkhir?></h3>

		              <p>Netral</p>
		            </div>
		            <div class="icon">
		              <i class="fa fa-question-circle"></i>
		            </div>
		            <a href="#" class="small-box-footer">
		              More info <i class="fa fa-arrow-circle-right"></i>
		            </a>
		          </div>
		        </div>
		        <!-- ./col -->
		        <div class="col-lg-3 col-xs-6">
		          <!-- small box -->
		          <div class="small-box bg-red">
		            <div class="inner">
		              <h3><?=$negatifAkhir?></h3>

		              <p>Negatif</p>
		            </div>
		            <div class="icon">
		              <i class="ion ion-sad"></i>
		            </div>
		            <a href="#" class="small-box-footer">
		              More info <i class="fa fa-arrow-circle-right"></i>
		            </a>
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
@endif
<div class="row">
	<div class="col-xs-12 col-md-6">

	  <div class="box box-danger">
	    <div class="box-header">
	      <h3 class="box-title">Bulan Ini</h3>
	    </div>
	    <!-- /.box-header -->
	    <div class="box-body">
			<div class="row">
		        <div class="col-lg-3 col-xs-6">
		          <!-- small box -->
		          <div class="small-box bg-aqua">
		            <div class="inner">
		              <h3><?=$dataBulanIni?></h3>

		              <p>Komentar</p>
		            </div>
		            <div class="icon">
		              <i class="fa fa-commenting"></i>
		            </div>
		            <a href="#" class="small-box-footer">
		              More info <i class="fa fa-arrow-circle-right"></i>
		            </a>
		          </div>
		        </div>
		        <!-- ./col -->
		        <div class="col-lg-3 col-xs-6">
		          <!-- small box -->
		          <div class="small-box bg-green">
		            <div class="inner">
		              <h3><?=$bulanIniPos?></h3>

		              <p>Positif</p>
		            </div>
		            <div class="icon">
		              <i class="ion ion-happy"></i>
		            </div>
		            <a href="#" class="small-box-footer">
		              More info <i class="fa fa-arrow-circle-right"></i>
		            </a>
		          </div>
		        </div>
		        <!-- ./col -->
		        <div class="col-lg-3 col-xs-6">
		          <!-- small box -->
		          <div class="small-box bg-yellow">
		            <div class="inner">
		              <h3><?=$bulanIniNet?></h3>

		              <p>Netral</p>
		            </div>
		            <div class="icon">
		              <i class="fa fa-question-circle"></i>
		            </div>
		            <a href="#" class="small-box-footer">
		              More info <i class="fa fa-arrow-circle-right"></i>
		            </a>
		          </div>
		        </div>
		        <!-- ./col -->
		        <div class="col-lg-3 col-xs-6">
		          <!-- small box -->
		          <div class="small-box bg-red">
		            <div class="inner">
		              <h3><?=$bulanIniNeg?></h3>

		              <p>Negatif</p>
		            </div>
		            <div class="icon">
		              <i class="ion ion-sad"></i>
		            </div>
		            <a href="#" class="small-box-footer">
		              More info <i class="fa fa-arrow-circle-right"></i>
		            </a>
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

	<div class="col-xs-12 col-md-6">

	  <div class="box box-danger">
	    <div class="box-header">
	      <h3 class="box-title">Tahun Ini</h3>
	    </div>
	    <!-- /.box-header -->
	    <div class="box-body">
			<div class="row">
		        <div class="col-lg-3 col-xs-6">
		          <!-- small box -->
		          <div class="small-box bg-aqua">
		            <div class="inner">
		              <h3><?=$dataTahunIni?></h3>

		              <p>Komentar</p>
		            </div>
		            <div class="icon">
		              <i class="fa fa-commenting"></i>
		            </div>
		            <a href="#" class="small-box-footer">
		              More info <i class="fa fa-arrow-circle-right"></i>
		            </a>
		          </div>
		        </div>
		        <!-- ./col -->
		        <div class="col-lg-3 col-xs-6">
		          <!-- small box -->
		          <div class="small-box bg-green">
		            <div class="inner">
		              <h3><?=$tahunIniPos?></h3>

		              <p>Positif</p>
		            </div>
		            <div class="icon">
		              <i class="ion ion-happy"></i>
		            </div>
		            <a href="#" class="small-box-footer">
		              More info <i class="fa fa-arrow-circle-right"></i>
		            </a>
		          </div>
		        </div>
		        <!-- ./col -->
		        <div class="col-lg-3 col-xs-6">
		          <!-- small box -->
		          <div class="small-box bg-yellow">
		            <div class="inner">
		              <h3><?=$tahunIniNet?></h3>

		              <p>Netral</p>
		            </div>
		            <div class="icon">
		              <i class="fa fa-question-circle"></i>
		            </div>
		            <a href="#" class="small-box-footer">
		              More info <i class="fa fa-arrow-circle-right"></i>
		            </a>
		          </div>
		        </div>
		        <!-- ./col -->
		        <div class="col-lg-3 col-xs-6">
		          <!-- small box -->
		          <div class="small-box bg-red">
		            <div class="inner">
		              <h3><?=$tahunIniNeg?></h3>

		              <p>Negatif</p>
		            </div>
		            <div class="icon">
		              <i class="ion ion-sad"></i>
		            </div>
		            <a href="#" class="small-box-footer">
		              More info <i class="fa fa-arrow-circle-right"></i>
		            </a>
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


@endsection

@section('script')
<script>
	var dataTableAdmin;
	$(document).ready(function() {
		// Aktifkan menu sidebar
		$('#menu-dashboard').addClass('active');

		// Ambil data admin dan tampilkan dengan datatable

	});
</script>
@endsection
