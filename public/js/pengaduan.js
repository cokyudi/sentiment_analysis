function detailPengaduan(id){
	let url = $('meta[name=url]').prop('content');
  $('#modal-pengaduan .modal-title').text('Detail Pengaduan');
  $('#modal-pengaduan .overlay').show();
  $('#modal-pengaduan').modal('show');

  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  $.ajax({
    url: url+'/pengaduan/'+id+'/read',
    type: 'post'
  })
  .done(function(data) {
    $('#modal-pengaduan p[name=peng_topik]').text(data.peng_topik);
		$('#modal-pengaduan p[name=peng_tanggal]').text(data.peng_tanggal);
		$('#modal-pengaduan p[name=peng_instansi]').text(data.peng_instansi);
		$('#modal-pengaduan p[name=peng_nama]').text(data.peng_nama);
		$('#modal-pengaduan p[name=peng_isi]').text(data.peng_isi);
		$('#modal-pengaduan p[name=pengtl_nama]').text(data.pengtl_nama);
		$('#modal-pengaduan p[name=pengtl_tgl]').text(data.pengtl_tgl);
		$('#modal-pengaduan p[name=pengtl_jawaban]').text(data.pengtl_jawaban);
  })
  .fail(function() {
    swal({title: 'Gagal', text: 'Terjadi error dalam pengiriman data', buttonsStyling: false, confirmButtonClass: "btn btn-danger", type: "error"});
  })
  .always(function() {
    $('#modal-pengaduan .overlay').hide();
  });
}
