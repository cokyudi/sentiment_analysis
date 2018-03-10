function deleteKomentar(id){
	let url = $('meta[name=url]').prop('content');
  $('#modal-komentar-2 .modal-title').text('Apakah anda yakin menghapus komentar berikut?');
  $('#modal-komentar-2 form').prop('action', url+'/komentar/'+id+'/delete');
  $('#modal-komentar-2 .btn-submit').show();
  $('#modal-komentar-2 .overlay').show();
  $('#modal-komentar-2').modal('show');

  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  $.ajax({
    url: url+'/komentar/'+id+'/read',
    type: 'post'
  })
  .done(function(data) {
    $('#modal-komentar-2 p[name=komentar]').text(data.komentar);
    $('#modal-komentar-2 p[name=pengtg_tgl]').text(data.pengtg_tgl);
  })
  .fail(function() {
    swal({title: 'Gagal', text: 'Terjadi error dalam pengiriman data', buttonsStyling: false, confirmButtonClass: "btn btn-danger", type: "error"});
  })
  .always(function() {
    $('#modal-komentar-2 .overlay').hide();
  });
}

// TODO : Fix delete Komentar
$('#modal-komentar-2 form').validate({
  submitHandler: function(form) {
    $('#modal-komentar-2 .overlay').show();
    $.ajax({
      url: form.action,
      type: 'post',
      data: $(form).serializeArray()
    })
    .done(function(data) {
      if(data.status==='OK'){
        swal({title: 'Sukses!', text: data.message, buttonsStyling: false, confirmButtonClass: "btn btn-success", type: "success"});
        if (typeof dataTableKomentar !== 'undefined') {
          dataTableKomentar.ajax.reload();
        }
      }
      else{
        swal({title: 'Gagal', text: data.message, buttonsStyling: false, confirmButtonClass: "btn btn-danger", type: "error"});
      }
    })
    .fail(function() {
      swal({title: 'Gagal', text: 'Terjadi error dalam pengiriman data', buttonsStyling: false, confirmButtonClass: "btn btn-danger", type: "error"});
    })
    .always(function() {
      $('#modal-komentar-2 .overlay').hide();
      $('#modal-komentar-2').modal('hide');
    });
  }
});
