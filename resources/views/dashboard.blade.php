@extends('master')

@section('title', config('app.name').' | Dashboard')
@section('header', 'Dashboard')

@section('content')
<div class="row">
	<div class="col-xs-12">

	  <div class="box box-danger">
	    <div class="box-header">
	      <h3 class="box-title">Dashboard</h3>
	    </div>
	    <!-- /.box-header -->
	    <!-- <div class="box-body table-responsive">
	      <table id="table-admin" class="table table-bordered table-striped">
	        <thead class="purple">
	        <tr>
	        	<th>Nama</th>
	        	<th>Level</th>
	        	<th>Aksi</th>
	        </tr>
	        </thead>
	        <tbody>

	        </tbody>
	        <tfoot>
	        <tr>
	          <th>Nama</th>
	          <th>Level</th>
	        	<th>Aksi</th>
	        </tr>
	        </tfoot>
	      </table>
	    </div> -->
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
