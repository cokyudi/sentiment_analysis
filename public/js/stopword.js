function addStopword(){
  let url = $('meta[name=url]').prop('content');
  $('#modal-stopword .modal-title').text('Tambah Stopword');
  $('#modal-stopword form').prop('action', url+'/stopword/store');
  $('#modal-stopword form')[0].reset();
  $('#modal-stopword form .form-group span.help-block').remove();
  $('#modal-stopword form .form-group').removeClass('has-error');
  $('#modal-stopword').modal('show');
}

function editStopword(id){
  let url = $('meta[name=url]').prop('content');
  $('#modal-stopword .modal-title').text('Perbaharui Stopword');
  $('#modal-stopword form').prop('action', url+'/stopword/'+id+'/update');
  $('#modal-stopword form')[0].reset();
  $('#modal-stopword form .form-group span.help-block').remove();
  $('#modal-stopword form .form-group').removeClass('has-error');
  $('#modal-stopword .overlay').show();
  $('#modal-stopword').modal('show');

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
    $('#modal-stopword input[name=kata]').val(data.kata);
  })
  .fail(function() {
    swal({title: 'Gagal', text: 'Terjadi error dalam pengiriman data', buttonsStyling: false, confirmButtonClass: "btn btn-danger", type: "error"});
  })
  .always(function() {
    $('#modal-stopword .overlay').hide();
  });
}

// Form validation bahasa indonesia
$('#modal-stopword form').validate({
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
    $('#modal-stopword .overlay').show();
    $.ajax({
      url: form.action,
      type: 'POST',
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
      $('#modal-stopword .overlay').hide();
      $('#modal-stopword').modal('hide');
    });
  }
});
