@extends('master')

@section('title', config('app.name').' | Komentar')
@section('header', 'komentar')

@section('content')
<div class="row">
	<div class="col-xs-12">

	  <div class="box box-danger">
	    <div class="box-header">
	      <h3 class="box-title">Daftar Komentar</h3>
	    </div>
	    <!-- /.box-header -->
	    <div class="box-body table-responsive">
	      <table id="table-komentar" class="table table-bordered table-striped">
	        <thead class="red">
	        <tr>
                <th>No.</th>
	        			<th>Komentar</th>
	        			<th>Jenis Data</th>
                <th>Sentimen Awal</th>
                <th>Aksi</th>
	        </tr>
	        </thead>
	        <tbody>

	        </tbody>
	        <tfoot>
	        <tr>
                <th>No.</th>
	        			<th>Komentar</th>
	        			<th>Jenis Data</th>
                <th>Sentimen Awal</th>
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

@include('modal/modal-komentar')
@include('modal/modal-komentar2')

@endsection

@section('script')
<script src="{{URL('public')}}/js/komentar.js"></script>
<script src="{{URL('public')}}/js/komentar2.js"></script>
<script>
	var dataTableKomentar;
	$(document).ready(function() {
		// Aktifkan menu sidebar
		$('#menu-komentar').addClass('active');

		dataTableKomentar = $('#table-komentar').DataTable({
	      "processing": true,
	      "serverSide": true,
	      "ajax":{
				"url": "{{ URL('komentar/data') }}",
				"dataType": "json",
				"type": "POST",
				"data":{ _token: "{{csrf_token()}}"}
	      },
	      "columns": [
	        	{ "data": "no"},
	        	{ "data": "komentar", "width" : "40%" },
            { "data": "jenis_data"},
            { "data": "sentimen_awal"},
	        	{ "data": "aksi","orderable": false }
	      ],
	      "order": [[3, "asc"]]
	  	});

	});
</script>
@endsection
