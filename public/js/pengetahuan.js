function addPengetahuan(){
  let url = $('meta[name=url]').prop('content');
  $('#modal-pengetahuan .modal-title').text('Tambah pengetahuan');
  $('#modal-pengetahuan form').prop('action', url+'/pengetahuan/store');
  $('#modal-pengetahuan form')[0].reset();
  $('#modal-pengetahuan form .form-group span.help-block').remove();
  $('#modal-pengetahuan form .form-group').removeClass('has-error');
  $('#modal-pengetahuan').modal('show');
}

function editPengetahuan(id){
  let url = $('meta[name=url]').prop('content');
  $('#modal-pengetahuan .modal-title').text('Perbaharui Pengetahuan');
  $('#modal-pengetahuan form').prop('action', url+'/pengetahuan/'+id+'/update');
  $('#modal-pengetahuan form')[0].reset();
  $('#modal-pengetahuan form .form-group span.help-block').remove();
  $('#modal-pengetahuan form .form-group').removeClass('has-error');
  $('#modal-pengetahuan .overlay').show();
  $('#modal-pengetahuan').modal('show');

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
    $('#modal-pengetahuan input[name=kata]').val(data.kata);
    $('#modal-pengetahuan input[name=nilai]').val(data.nilai);
  })
  .fail(function() {
    swal({title: 'Gagal', text: 'Terjadi error dalam pengiriman data', buttonsStyling: false, confirmButtonClass: "btn btn-danger", type: "error"});
  })
  .always(function() {
    $('#modal-pengetahuan .overlay').hide();
  });
}

// Form validation bahasa indonesia
$('#modal-pengetahuan form').validate({
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
    $('#modal-pengetahuan .overlay').show();
    $.ajax({
      url: form.action,
      type: 'POST',
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
      $('#modal-pengetahuan .overlay').hide();
      $('#modal-pengetahuan').modal('hide');
    });
  }
});
