function deletePengetahuan(id){
	let url = $('meta[name=url]').prop('content');
  $('#modal-pengetahuan-2 .modal-title').text('Apakah anda yakin menghapus pengetahuan berikut?');
  $('#modal-pengetahuan-2 form').prop('action', url+'/pengetahuan/'+id+'/delete');
  $('#modal-pengetahuan-2 .btn-submit').show();
  $('#modal-pengetahuan-2 .overlay').show();
  $('#modal-pengetahuan-2').modal('show');

  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  $.ajax({
    url: url+'/pengetahuan/'+id+'/read',
    type: 'post'
  })
  .done(function(data) {
    $('#modal-pengetahuan-2 p[name=kata]').text(data.kata);
    $('#modal-pengetahuan-2 p[name=frekuensi]').text(data.frekuensi);
    $('#modal-pengetahuan-2 p[name=n_chisquare]').text(data.n_chisquare);
    $('#modal-pengetahuan-2 p[name=n_netral]').text(data.n_netral);
    $('#modal-pengetahuan-2 p[name=n_positif]').text(data.n_positif);
    $('#modal-pengetahuan-2 p[name=n_negatif]').text(data.n_negatif);
  })
  .fail(function() {
    swal({title: 'Gagal', text: 'Terjadi error dalam pengiriman data', buttonsStyling: false, confirmButtonClass: "btn btn-danger", type: "error"});
  })
  .always(function() {
    $('#modal-pengetahuan-2 .overlay').hide();
  });
}

// TODO : Fix delete pengetahuan
$('#modal-pengetahuan-2 form').validate({
  submitHandler: function(form) {
    $('#modal-pengetahuan-2 .overlay').show();
    $.ajax({
      url: form.action,
      type: 'post',
      data: $(form).serializeArray()
    })
    .done(function(data) {
      if(data.status==='OK'){
        swal({title: 'Sukses!', text: data.message, buttonsStyling: false, confirmButtonClass: "btn btn-success", type: "success"});
        if (typeof dataTablePengetahuan !== 'undefined') {
          dataTablePengetahuan.ajax.reload();
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
      $('#modal-pengetahuan-2 .overlay').hide();
      $('#modal-pengetahuan-2').modal('hide');
    });
  }
});
