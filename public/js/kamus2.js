function deleteKamus(id){
	let url = $('meta[name=url]').prop('content');
  $('#modal-kamus-2 .modal-title').text('Apakah anda yakin menghapus kamus berikut?');
  $('#modal-kamus-2 form').prop('action', url+'/kamus/'+id+'/delete');
  $('#modal-kamus-2 .btn-submit').show();
  $('#modal-kamus-2 .overlay').show();
  $('#modal-kamus-2').modal('show');

  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  $.ajax({
    url: url+'/kamus/'+id+'/read',
    type: 'post'
  })
  .done(function(data) {
    $('#modal-kamus-2 p[name=kata_singkatan]').text(data.kata_singkatan);
    $('#modal-kamus-2 p[name=kata_asli]').text(data.kata_asli);
  })
  .fail(function() {
    swal({title: 'Gagal', text: 'Terjadi error dalam pengiriman data', buttonsStyling: false, confirmButtonClass: "btn btn-danger", type: "error"});
  })
  .always(function() {
    $('#modal-kamus-2 .overlay').hide();
  });
}

// TODO : Fix delete kamus
$('#modal-kamus-2 form').validate({
  submitHandler: function(form) {
    $('#modal-kamus-2 .overlay').show();
    $.ajax({
      url: form.action,
      type: 'post',
      data: $(form).serializeArray()
    })
    .done(function(data) {
      if(data.status==='OK'){
        swal({title: 'Sukses!', text: data.message, buttonsStyling: false, confirmButtonClass: "btn btn-success", type: "success"});
        if (typeof dataTableKamus !== 'undefined') {
          dataTableKamus.ajax.reload();
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
      $('#modal-kamus-2 .overlay').hide();
      $('#modal-kamus-2').modal('hide');
    });
  }
});
