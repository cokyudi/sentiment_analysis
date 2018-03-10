function addKamus(){
  let url = $('meta[name=url]').prop('content');
  $('#modal-kamus .modal-title').text('Tambah Kamus');
  $('#modal-kamus form').prop('action', url+'/kamus/store');
  $('#modal-kamus form')[0].reset();
  $('#modal-kamus form .form-group span.help-block').remove();
  $('#modal-kamus form .form-group').removeClass('has-error');
  $('#modal-kamus').modal('show');
}

function editKamus(id){
  let url = $('meta[name=url]').prop('content');
  $('#modal-kamus .modal-title').text('Perbaharui Kamus');
  $('#modal-kamus form').prop('action', url+'/kamus/'+id+'/update');
  $('#modal-kamus form')[0].reset();
  $('#modal-kamus form .form-group span.help-block').remove();
  $('#modal-kamus form .form-group').removeClass('has-error');
  $('#modal-kamus .overlay').show();
  $('#modal-kamus').modal('show');

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
    $('#modal-kamus input[name=kata_singkatan]').val(data.kata_singkatan);
    $('#modal-kamus input[name=kata_asli]').val(data.kata_asli);
  })
  .fail(function() {
    swal({title: 'Gagal', text: 'Terjadi error dalam pengiriman data', buttonsStyling: false, confirmButtonClass: "btn btn-danger", type: "error"});
  })
  .always(function() {
    $('#modal-kamus .overlay').hide();
  });
}

// Form validation bahasa indonesia
$('#modal-kamus form').validate({
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
    $('#modal-kamus .overlay').show();
    $.ajax({
      url: form.action,
      type: 'POST',
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
      $('#modal-kamus .overlay').hide();
      $('#modal-kamus').modal('hide');
    });
  }
});
