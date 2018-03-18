function doTraining() {
    let url = $('meta[name=url]').prop('content');
    $('#modal-training .modal-title').text('Anda Yakin Lakukan Training ?');
    $('#modal-training form').prop('action', url+'/training/doTraining');
    $('#modal-training form .form-group span.help-block').remove();
    $('#modal-training form .form-group').removeClass('has-error');
    $('#modal-training').modal('show');
}

$('#modal-training form').validate({
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
    $('#modal-training .overlay').show();
    $.ajax({
      url: form.action,
      type: 'POST',
      data: $(form).serializeArray()
    })
    .done(function(data) {
      if(data.status==='OK'){
        swal({title: 'Sukses!', text: JSON.stringify(data.message), buttonsStyling: false, confirmButtonClass: "btn btn-success", type: "success"});
        if (typeof dataTableTraining !== 'undefined') {
          dataTableTraining.ajax.reload();
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
      $('#modal-training .overlay').hide();
      $('#modal-training').modal('hide');
    });
  }
});
