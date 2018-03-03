function deleteStopword(id){
	let url = $('meta[name=url]').prop('content');
  $('#modal-stopword-2 .modal-title').text('Apakah anda yakin menghapus stopword berikut?');
  $('#modal-stopword-2 form').prop('action', url+'/stopword/'+id+'/delete');
  $('#modal-stopword-2 .btn-submit').show();
  $('#modal-stopword-2 .overlay').show();
  $('#modal-stopword-2').modal('show');

  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  $.ajax({
    url: url+'/stopword/'+id+'/read',
    type: 'post'
  })
  .done(function(data) {
    $('#modal-stopword-2 p[name=kata]').text(data.kata);
  })
  .fail(function() {
    swal({title: 'Gagal', text: 'Terjadi error dalam pengiriman data', buttonsStyling: false, confirmButtonClass: "btn btn-danger", type: "error"});
  })
  .always(function() {
    $('#modal-stopword-2 .overlay').hide();
  });
}

// TODO : Fix delete stopword
$('#modal-stopword-2 form').validate({
  submitHandler: function(form) {
    $('#modal-stopword-2 .overlay').show();
    $.ajax({
      url: form.action,
      type: 'post',
      data: $(form).serializeArray()
    })
    .done(function(data) {
      if(data.status==='OK'){
        swal({title: 'Sukses!', text: data.message, buttonsStyling: false, confirmButtonClass: "btn btn-success", type: "success"});
        if (typeof dataTableStopword !== 'undefined') {
          dataTableStopword.ajax.reload();
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
      $('#modal-stopword-2 .overlay').hide();
      $('#modal-stopword-2').modal('hide');
    });
  }
});
