function changePasswordAdmin(id){
  let url = $('meta[name=url]').prop('content');
  $('#modal-admin-3 .modal-title').text('Ganti Password Admin');
  $('#modal-admin-3 form').prop('action', url+'/admin/'+id+'/updatePassword');
  $('#modal-admin-3 form')[0].reset();
  $('#modal-admin-3 .overlay').show();
  $('#modal-admin-3').modal('show');

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
    $('#modal-admin-3 p[name=nama]').text(data.nama);
  })
  .fail(function() {
    swal({title: 'Gagal', text: 'Terjadi error dalam pengiriman data', buttonsStyling: false, confirmButtonClass: "btn btn-danger", type: "error"});
  })
  .always(function() {
    $('#modal-admin-3 .overlay').hide();
  });
}

// Form validation bahasa indonesia
$('#modal-admin-3 form').validate({
  lang: 'id',
  errorElement: 'span',
  errorClass: 'help-block',
  errorPlacement: function(error, element) {
    error.insertAfter(element);
  },
  highlight: function(element) {
    $(element).closest('div').addClass('has-error');
  },
  unhighlight: function(element) {
    $(element).closest('div').removeClass('has-error');
  },
  submitHandler: function(form) {
    $('#modal-admin-3 .overlay').show();
    $.ajax({
      url: form.action,
      type: 'POST',
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
      $('#modal-admin-3 .overlay').hide();
      $('#modal-admin-3').modal('hide');
    });
  }
});
