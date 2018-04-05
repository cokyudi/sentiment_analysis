@extends('master')

@section('title', config('app.name').' | testing')
@section('header', 'testing')

@section('content')
<div class="row">
	<div class="col-xs-12">

	  <div class="box box-danger">
	    <div class="box-header">
	      <h3 class="box-title">Testing</h3>
	      <div class="btn-group pull-right">
	      	<button class="btn btn-primary" onClick="doTesting();"><i class="fa fa-plus"></i>&nbsp&nbsp Testing</button>
	      </div>
	    </div>
	    <!-- /.box-header -->
	    <div class="box-body table-responsive">
	      <table id="table-testing" class="table table-bordered table-striped">
	        <thead class="red">
	        <tr>
                <th>No.</th>
	        	<th>Komentar</th>
	        	<th>Text Processing</th>
                <th>Sentimen Pakar</th>
				<th>Sentimen Sistem</th>
	        </tr>
	        </thead>
	        <tbody>

	        </tbody>
	        <tfoot>
	        <tr>
                <th>No.</th>
	        	<th>Komentar</th>
	        	<th>Text Processing</th>
                <th>Sentimen Pakar</th>
				<th>Sentimen Sistem</th>
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

@include('modal/modal-testing')
@include('modal/modal-testing2')

@endsection

@section('script')
<script src="{{URL('public')}}/js/testing.js"></script>
<script src="{{URL('public')}}/js/testing2.js"></script>
<script>
	var dataTableTesting;
	$(document).ready(function() {
		// Aktifkan menu sidebar
		$('#menu-testing').addClass('active');

		dataTableTesting = $('#table-testing').DataTable({
	      "processing": true,
	      "serverSide": true,
	      "ajax":{
				"url": "{{ URL('testing/data') }}",
				"dataType": "json",
				"type": "POST",
				"data":{ _token: "{{csrf_token()}}"}
	      },
	      "columns": [
	        { "data": "no"},
	        { "data": "komentar"},
            { "data": "text_prc"},
            { "data": "sentimen_awal"},
			{ "data": "sentimen_akhir"}
	      ],
	      "order": [[4, "asc"]]
	  	});

	});
</script>
@endsection
