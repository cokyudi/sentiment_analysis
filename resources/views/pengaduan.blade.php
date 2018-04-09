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
	        <thead class="red">
	        <tr>
                <th>No.</th>
                <th>Judul Pengaduan</th>
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

<!-- @include('modal/modal-pengaduan')
@include('modal/modal-pengaduan2') -->

@endsection

@section('script')
<!-- <script src="{{URL('public')}}/js/pengaduan.js"></script>
<script src="{{URL('public')}}/js/pengaduan2.js"></script> -->
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
				"data":{ _token: "{{csrf_token()}}"}
	      },
	      "columns": [
	        { "data": "no" },
            { "data": "peng_topik" },
            { "data": "komentar" },
            { "data": "pengtg_tgl" },
            { "data": "sentimen" },
	        { "data": "aksi", "orderable": false }
	      ],
	      "order": [[2, "asc"]]
	  	});
	});
</script>
@endsection
