function doOneTesting() {
    let url = $('meta[name=url]').prop('content');
    $('#modal-testing2 .modal-title').text('Testing');
    $('#modal-testing2 form').prop('action', url+'/testing/doOneTesting');
    $('#modal-testing2 form .form-group span.help-block').remove();
    $('#modal-testing2 form')[0].reset();
    $('#modal-testing2 form .form-group').removeClass('has-error');
    $('#modal-testing2').modal('show');
}

$('#modal-testing2 form').validate({
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
    $('#modal-testing2 .overlay').show();
    $.ajax({
      url: form.action,
      type: 'POST',
      data: $(form).serializeArray()
    })
    .done(function(data) {
      if(data.status==='OK'){
        swal({title: data.hasil, text: data.message, buttonsStyling: false, confirmButtonClass: data.btn, type: data.tipe});
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
      $('#modal-testing2 .overlay').hide();
      $('#modal-testing2').modal('hide');
    });
  }
});
