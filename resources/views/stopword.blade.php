@extends('master')

@section('title', config('app.name').' | Admin')
@section('header', 'Stopword')

@section('content')
<div class="row">
	<div class="col-xs-12">

	  <div class="box box-danger">
	    <div class="box-header">
	      <h3 class="box-title">Daftar Stopword</h3>
	      <div class="btn-group pull-right">
	      	<button class="btn btn-primary" onClick="addStopword();"><i class="fa fa-plus"></i>&nbsp&nbsp Tambah Stopword</button>
	      </div>
	    </div>
	    <!-- /.box-header -->
	    <div class="box-body table-responsive">
	      <table id="table-stopword" class="table table-bordered table-striped">
	        <thead class="red">
	        <tr>
                <th>No.</th>
	        	<th>Kata</th>
	        	<th>Aksi</th>
	        </tr>
	        </thead>
	        <tbody>

	        </tbody>
	        <tfoot>
	        <tr>
                <th>No.</th>
	          	<th>Kata</th>
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

@include('modal/modal-stopword')
@include('modal/modal-stopword2')

@endsection

@section('script')
<script src="{{URL('public')}}/js/stopword.js"></script>
<script src="{{URL('public')}}/js/stopword2.js"></script>
<script>
	var dataTableStopword;
	$(document).ready(function() {
		// Aktifkan menu sidebar
		$('#menu-stopword').addClass('active');

		dataTableStopword = $('#table-stopword').DataTable({
	      "processing": true,
	      "serverSide": true,
	      "ajax":{
				"url": "{{ URL('stopword/data') }}",
				"dataType": "json",
				"type": "POST",
				"data":{ _token: "{{csrf_token()}}"}
	      },
	      "columns": [
	        { "data": "no" },
	        { "data": "kata" },
	        { "data": "aksi", "orderable": false }
	      ],
	      "order": [[0, "desc"]]
	  	});

	});
</script>
@endsection
