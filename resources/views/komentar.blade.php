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
					<div class="row">
						<div class="col-sm-3">
	            <div class="form-group">
	              <label>Sentimen</label>
	              <select name="sentimen" id="select-sentimen" class="form-control" required="true">
									<option value="0" selected>Semua</option>
	                <option value="3">Netral</option>
	                <option value="1">Positif</option>
	                <option value="2">Negatif</option>
	              </select>
	            </div>
	          </div>
						<div class="col-sm-3">
	            <div class="form-group">
	              <label>Jenis Data</label>
	              <select name="jenis_data" id="select-jenis" class="form-control" required="true">
									<option value="0" selected>Semua</option>
	                <option value="belum">Belum</option>
	                <option value="training">Training</option>
	                <option value="testing">Testing</option>
	              </select>
	            </div>
	          </div>
					</div>

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
				"data": function ( data ) {
              data._token = "{{csrf_token()}}";
              data.sentimen = $('select[name=sentimen]').val();
							data.jenis_data = $('select[name=jenis_data]').val();
          }
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

			$('#select-sentimen').change(function() {
        dataTableKomentar.draw();
    	});

			$('#select-jenis').change(function() {
        dataTableKomentar.draw();
    	});

	});
</script>
@endsection
