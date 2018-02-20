function detailAdmin(id){
	let url = $('meta[name=url]').prop('content');
  $('#modal-admin-2 .modal-title').text('Detail Admin');
  $('#modal-admin-2 form').prop('action', '#');
  $('#modal-admin-2 .btn-submit').hide();
  $('#modal-admin-2 .overlay').show();
  $('#modal-admin-2').modal('show');

  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  $.ajax({
    url: url+'/admin/'+id+'/read',
    type: 'post'
  })
  .done(function(data) {
    $('#modal-admin-2 p[name=nama]').text(data.nama);
    $('#modal-admin-2 p[name=level]').text(data.level==1?'Super Admin':'Admin');
  })
  .fail(function() {
    swal({title: 'Gagal', text: 'Terjadi error dalam pengiriman data', buttonsStyling: false, confirmButtonClass: "btn btn-danger", type: "error"});
  })
  .always(function() {
    $('#modal-admin-2 .overlay').hide();
  });
}

function deleteAdmin(id){
	let url = $('meta[name=url]').prop('content');
  $('#modal-admin-2 .modal-title').text('Apakah anda yakin menghapus admin berikut?');
  $('#modal-admin-2 form').prop('action', url+'/admin/'+id+'/delete');
  $('#modal-admin-2 .btn-submit').show();
  $('#modal-admin-2 .overlay').show();
  $('#modal-admin-2').modal('show');

  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  $.ajax({
    url: url+'/admin/'+id+'/read',
    type: 'post'
  })
  .done(function(data) {
    $('#modal-admin-2 p[name=nama]').text(data.nama);
    $('#modal-admin-2 p[name=level]').text(data.level==1?'Super Admin':'Admin');
  })
  .fail(function() {
    swal({title: 'Gagal', text: 'Terjadi error dalam pengiriman data', buttonsStyling: false, confirmButtonClass: "btn btn-danger", type: "error"});
  })
  .always(function() {
    $('#modal-admin-2 .overlay').hide();
  });
}

// TODO : Fix delete admin
$('#modal-admin-2 form').validate({
  submitHandler: function(form) {
    $('#modal-admin-2 .overlay').show();
    $.ajax({
      url: form.action,
      type: 'post',
      data: $(form).serializeArray()
    })
    .done(function(data) {
      if(data.status==='OK'){
        swal({title: 'Sukses!', text: data.message, buttonsStyling: false, confirmButtonClass: "btn btn-success", type: "success"});
        if (typeof dataTableAdmin !== 'undefined') {
          dataTableAdmin.ajax.reload();
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
      $('#modal-admin-2 .overlay').hide();
      $('#modal-admin-2').modal('hide');
    });
  }
});
