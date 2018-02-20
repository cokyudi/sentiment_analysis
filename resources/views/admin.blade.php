@extends('master')

@section('title', config('app.name').' | Admin')
@section('header', 'Admin')

@section('content')
<div class="row">
	<div class="col-xs-12">

	  <div class="box box-danger">
	    <div class="box-header">
	      <h3 class="box-title">Daftar Admin</h3>
	      <div class="btn-group pull-right">
	      	<button class="btn btn-primary" onClick="addAdmin();"><i class="fa fa-plus"></i>&nbsp&nbsp Tambah Admin</button>
	      </div>
	    </div>
	    <!-- /.box-header -->
	    <div class="box-body table-responsive">
	      <table id="table-admin" class="table table-bordered table-striped">
	        <thead class="red">
	        <tr>
	        	<th>Nama</th>
	        	<th>Level</th>
				<th>Username</th>
	        	<th>Aksi</th>
	        </tr>
	        </thead>
	        <tbody>

	        </tbody>
	        <tfoot>
	        <tr>
	          	<th>Nama</th>
	          	<th>Level</th>
				<th>Username</th>
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

@include('modal/modal-admin')
@include('modal/modal-admin2')
@include('modal/modal-admin3')

@endsection

@section('script')
<script src="{{URL('public')}}/js/admin.js"></script>
<script src="{{URL('public')}}/js/admin2.js"></script>
<script src="{{URL('public')}}/js/admin3.js"></script>
<script>
	var dataTableAdmin;
	$(document).ready(function() {
		// Aktifkan menu sidebar
		$('#menu-admin').addClass('active');

		// Ambil data admin dan tampilkan dengan datatable
		dataTableAdmin = $('#table-admin').DataTable({
	      "processing": true,
	      "serverSide": true,
	      "ajax":{
				"url": "{{ URL('admin/data') }}",
				"dataType": "json",
				"type": "POST",
				"data":{ _token: "{{csrf_token()}}"}
	      },
	      "columns": [
	        { "data": "nama" },
	        { "data": "level" },
			{ "data": "username" },
	        { "data": "aksi", "orderable": false }
	      ],
	      "order": [[0, "desc"]]
	  	});

	});
</script>
@endsection
