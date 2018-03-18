@extends('master')

@section('title', config('app.name').' | Training')
@section('header', 'training')

@section('content')
<div class="row">
	<div class="col-xs-12">

	  <div class="box box-danger">
	    <div class="box-header">
	      <h3 class="box-title">Training</h3>
	      <div class="btn-group pull-right">
	      	<button class="btn btn-primary" onClick="doTraining();"><i class="fa fa-plus"></i>&nbsp&nbsp Training</button>
	      </div>
	    </div>
	    <!-- /.box-header -->
	    <div class="box-body table-responsive">
	      <table id="table-training" class="table table-bordered table-striped">
	        <thead class="red">
	        <tr>
                <th>No.</th>
	        	<th>Komentar</th>
	        	<th>Text Processing</th>
                <th>Sentimen Awal</th>
	        </tr>
	        </thead>
	        <tbody>

	        </tbody>
	        <tfoot>
	        <tr>
                <th>No.</th>
	        	<th>Komentar</th>
	        	<th>Text Processing</th>
                <th>Sentimen Awal</th>
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

@include('modal/modal-training')
@include('modal/modal-training2')

@endsection

@section('script')
<script src="{{URL('public')}}/js/training.js"></script>
<script src="{{URL('public')}}/js/training2.js"></script>
<script>
	var dataTableTraining;
	$(document).ready(function() {
		// Aktifkan menu sidebar
		$('#menu-training').addClass('active');

		dataTableTraining = $('#table-training').DataTable({
	      "processing": true,
	      "serverSide": true,
	      "ajax":{
				"url": "{{ URL('training/data') }}",
				"dataType": "json",
				"type": "POST",
				"data":{ _token: "{{csrf_token()}}"}
	      },
	      "columns": [
	        { "data": "no", "width" : "5%" },
	        { "data": "komentar", "width" : "55%" },
            { "data": "text_prc", "width" : "30%" },
            { "data": "sentimen_awal", "width" : "10%" }
	      ],
	      "order": [[3, "asc"]]
	  	});

	});
</script>
@endsection
