@extends('master')

@section('title', config('app.name').' | pengaduan')
@section('header', 'pengaduan')

@section('content')
<div class="row">
	<div class="col-xs-12">

	  <div class="box box-danger">
	    <div class="box-header">
	      <h3 class="box-title">Daftar Pengaduan</h3>
	    </div>
	    <!-- /.box-header -->
	    <div class="box-body table-responsive">
	      <table id="table-pengaduan" class="table table-bordered table-striped">
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
	              <label>Instansi</label>
	              <select name="peng_instansi" id="select-instansi" class="form-control" required="true">
									<option value="0" selected>Semua</option>
						<?php foreach($instansis as $instansi){?>
	                <option value="<?=$instansi->nama_instansi?>"><?=$instansi->nama_instansi?></option>
						<?php } ?>
	              </select>
	            </div>
	          </div>
						</div>
					</div>
	        <thead class="red">
		        <tr>
                <th>No.</th>
                <th>Judul Pengaduan</th>
								<th>Instansi</th>
                <th>Komentar</th>
                <th>Tanggal Komentar</th>
                <th>Sentimen</th>
	        			<th>Aksi</th>
		        </tr>
	        </thead>
	        <tbody>

	        </tbody>
	        <tfoot>
		        <tr>
                <th>No.</th>
                <th>Judul Pengaduan</th>
								<th>Instansi</th>
                <th>Komentar</th>
                <th>Tanggal Komentar</th>
                <th>Sentimen</th>
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

@include('modal/modal-pengaduan')
@include('modal/modal-pengaduan2')

@endsection

@section('script')
<script src="{{URL('public')}}/js/pengaduan.js"></script>
<script src="{{URL('public')}}/js/pengaduan2.js"></script>
<script>
	var dataTablePengaduan;

	$(document).ready(function() {
		// Aktifkan menu sidebar
		$('#menu-pengaduan').addClass('active');

		dataTablePengaduan = $('#table-pengaduan').DataTable({
	      "processing": true,
	      "serverSide": true,
	      "ajax":{
				"url": "{{ URL('pengaduan/data') }}",
				"dataType": "json",
				"type": "POST",
				"data": function ( data ) {
              data._token = "{{csrf_token()}}";
              data.sentimen = $('select[name=sentimen]').val();
							data.peng_instansi = $('select[name=peng_instansi]').val();
          }
	      },
	      "columns": [
	        	{ "data": "no" },
            { "data": "peng_topik" },
						{ "data": "peng_instansi" },
            { "data": "komentar" },
            { "data": "pengtg_tgl" },
            { "data": "sentimen" },
	        { "data": "aksi", "orderable": false }
	      ],
	      "order": [[4, "asc"]]
	  	});

			$('#select-sentimen').change(function() {
        dataTablePengaduan.draw();
    	});

			$('#select-instansi').change(function() {
        dataTablePengaduan.draw();
    	});
	});
</script>
@endsection
