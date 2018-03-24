@extends('master')

@section('title', config('app.name').' | pengetahuan')
@section('header', 'pengetahuan')

@section('content')
<div class="row">
	<div class="col-xs-12">

	  <div class="box box-danger">
	    <div class="box-header">
	      <h3 class="box-title">Daftar Pengetahuan</h3>
	      <div class="btn-group pull-right">
	      	<button class="btn btn-primary" onClick="addPengetahuan();"><i class="fa fa-plus"></i>&nbsp&nbsp Tambah Pengetahuan</button>
	      </div>
	    </div>
	    <!-- /.box-header -->
	    <div class="box-body table-responsive">
	      <table id="table-pengetahuan" class="table table-bordered table-striped">
	        <thead class="red">
	        <tr>
                <th>No.</th>
	        	<th>Kata</th>
                <th>Nilai</th>
	        	<th>Aksi</th>
	        </tr>
	        </thead>
	        <tbody>

	        </tbody>
	        <tfoot>
	        <tr>
                <th>No.</th>
	          	<th>Kata</th>
                <th>Nilai</th>
	        	<th>Aksi</th>
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

@include('modal/modal-pengetahuan')
@include('modal/modal-pengetahuan2')

@endsection

@section('script')
<script src="{{URL('public')}}/js/pengetahuan.js"></script>
<script src="{{URL('public')}}/js/pengetahuan2.js"></script>
<script>
	var dataTablePengetahuan;
	$(document).ready(function() {
		// Aktifkan menu sidebar
		$('#menu-pengetahuan').addClass('active');

		dataTablePengetahuan = $('#table-pengetahuan').DataTable({
	      "processing": true,
	      "serverSide": true,
	      "ajax":{
				"url": "{{ URL('pengetahuan/data') }}",
				"dataType": "json",
				"type": "POST",
				"data":{ _token: "{{csrf_token()}}"}
	      },
	      "columns": [
	        { "data": "no" },
	        { "data": "kata" },
            { "data": "nilai" },
	        { "data": "aksi", "orderable": false }
	      ],
	      "order": [[1, "desc"]]
	  	});

	});
</script>
@endsection
