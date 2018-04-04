function doTesting() {
    let url = $('meta[name=url]').prop('content');
    $('#modal-testing .modal-title').text('Anda Yakin Lakukan testing ?');
    $('#modal-testing form').prop('action', url+'/testing/doTesting');
    $('#modal-testing form .form-group span.help-block').remove();
    $('#modal-testing form .form-group').removeClass('has-error');
    $('#modal-testing').modal('show');
}

$('#modal-testing form').validate({
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
    $('#modal-testing .overlay').show();
    $.ajax({
      url: form.action,
      type: 'POST',
      data: $(form).serializeArray()
    })
    .done(function(data) {
      if(data.status==='OK'){
        swal({title: 'Sukses!', text: JSON.stringify(data.message), buttonsStyling: false, confirmButtonClass: "btn btn-success", type: "success"});
        if (typeof dataTableTesting !== 'undefined') {
          dataTableTesting.ajax.reload();
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
      $('#modal-testing .overlay').hide();
      $('#modal-testing').modal('hide');
    });
  }
});
