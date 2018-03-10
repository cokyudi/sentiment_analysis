@extends('master')

@section('title', config('app.name').' | kamus')
@section('header', 'Kamus')

@section('content')
<div class="row">
	<div class="col-xs-12">

	  <div class="box box-danger">
	    <div class="box-header">
	      <h3 class="box-title">Daftar Kamus</h3>
	      <div class="btn-group pull-right">
	      	<button class="btn btn-primary" onClick="addKamus();"><i class="fa fa-plus"></i>&nbsp&nbsp Tambah kamus</button>
	      </div>
	    </div>
	    <!-- /.box-header -->
	    <div class="box-body table-responsive">
	      <table id="table-kamus" class="table table-bordered table-striped">
	        <thead class="red">
	        <tr>
                <th>No.</th>
	        	<th>Kata Singkatan</th>
	        	<th>Kata Asli</th>
                <th>Aksi</th>
	        </tr>
	        </thead>
	        <tbody>

	        </tbody>
	        <tfoot>
	        <tr>
                <th>No.</th>
	          	<th>Kata Singkatan</th>
	        	<th>Kata Asli</th>
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

@include('modal/modal-kamus')
@include('modal/modal-kamus2')

@endsection

@section('script')
<script src="{{URL('public')}}/js/kamus.js"></script>
<script src="{{URL('public')}}/js/kamus2.js"></script>
<script>
	var dataTableKamus;
	$(document).ready(function() {
		// Aktifkan menu sidebar
		$('#menu-kamus').addClass('active');

		dataTableKamus = $('#table-kamus').DataTable({
	      "processing": true,
	      "serverSide": true,
	      "ajax":{
				"url": "{{ URL('kamus/data') }}",
				"dataType": "json",
				"type": "POST",
				"data":{ _token: "{{csrf_token()}}"}
	      },
	      "columns": [
	        { "data": "no" },
	        { "data": "kata_singkatan" },
            { "data": "kata_asli" },
	        { "data": "aksi", "orderable": false }
	      ],
	      "order": [[0, "asc"]]
	  	});

	});
</script>
@endsection
