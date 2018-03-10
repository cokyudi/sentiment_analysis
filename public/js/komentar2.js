function changeJenisData(id){
    let url = $('meta[name=url]').prop('content');
    var jenis_data = $('#selectJenisData-'+id).val();
    var data = {
        jenis_data:jenis_data,
    }
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    $.ajax({
      url: url+'/komentar/'+id+'/updateJenisData',
      type: 'post',
      data: data
    })
    .done(function(data) {
      if(data.status==='OK'){
        swal({title: 'Sukses!', text: data.message, buttonsStyling: false, confirmButtonClass: "btn btn-success", type: "success"});
        if (typeof dataTableKomentar !== 'undefined') {
          dataTableKomentar.ajax.reload(null,false);
        }
      }
      else{
        swal({title: 'Gagal', text: data.message, buttonsStyling: false, confirmButtonClass: "btn btn-danger", type: "error"});
      }
    })
    .fail(function() {
      swal({title: 'Gagal', text: 'Terjadi error dalam pengiriman data', buttonsStyling: false, confirmButtonClass: "btn btn-danger", type: "error"});
    })
}

function changeSentAwal(id){
    let url = $('meta[name=url]').prop('content');
    var sentimen_awal = $('#selectSentAwal-'+id).val();
    var data = {
        sentimen_awal:sentimen_awal,
    }
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    $.ajax({
      url: url+'/komentar/'+id+'/updateSentAwal',
      type: 'post',
      data: data
    })
    .done(function(data) {
      if(data.status==='OK'){
        swal({title: 'Sukses!', text: data.message, buttonsStyling: false, confirmButtonClass: "btn btn-success", type: "success"});
        if (typeof dataTableKomentar !== 'undefined') {
          dataTableKomentar.ajax.reload(null,false);
        }
      }
      else{
        swal({title: 'Gagal', text: data.message, buttonsStyling: false, confirmButtonClass: "btn btn-danger", type: "error"});
      }
    })
    .fail(function() {
      swal({title: 'Gagal', text: 'Terjadi error dalam pengiriman data', buttonsStyling: false, confirmButtonClass: "btn btn-danger", type: "error"});
    })
}
