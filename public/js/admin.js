function addAdmin(){
  let url = $('meta[name=url]').prop('content');
  $('#modal-admin .modal-title').text('Tambah Admin');
  $('#modal-admin form').prop('action', url+'/admin/store');
  $('#modal-admin form .password').show();
  $('#modal-admin form')[0].reset();
  $('#modal-admin form .form-group span.help-block').remove();
  $('#modal-admin form .form-group').removeClass('has-error');
  $('#modal-admin').modal('show');
}

function editAdmin(id){
  let url = $('meta[name=url]').prop('content');
  $('#modal-admin .modal-title').text('Perbaharui Admin');
  $('#modal-admin form').prop('action', url+'/admin/'+id+'/update');
  $('#modal-admin form .password').hide();
  $('#modal-admin form')[0].reset();
  $('#modal-admin form .form-group span.help-block').remove();
  $('#modal-admin form .form-group').removeClass('has-error');
  $('#modal-admin .overlay').show();
  $('#modal-admin').modal('show');

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
    $('#modal-admin input[name=nama]').val(data.nama);
    $('#modal-admin select[name=level] option').prop('selected', false);
    $('#modal-admin select[name=level] option[value='+data.level+']').prop('selected', true);
    $('#modal-admin input[name=username]').val(data.username);
  })
  .fail(function() {
    swal({title: 'Gagal', text: 'Terjadi error dalam pengiriman data', buttonsStyling: false, confirmButtonClass: "btn btn-danger", type: "error"});
  })
  .always(function() {
    $('#modal-admin .overlay').hide();
  });
}

// Form validation bahasa indonesia
$('#modal-admin form').validate({
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
    $('#modal-admin .overlay').show();
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
      $('#modal-admin .overlay').hide();
      $('#modal-admin').modal('hide');
    });
  }
});
