<div class="modal fade" id="modal-pengaduan" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header red">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"></h4>
      </div>
      <div class="modal-body">

        <ul class="nav nav-tabs">
          <li class="active"><a data-toggle="tab" href="#pengaduan">Pengaduan</a></li>
          <li><a data-toggle="tab" href="#tindakLanjut">Tindak Lanjut</a></li>
        </ul>

        <div class="tab-content">
          <div id="pengaduan" class="tab-pane fade in active">
            <div class="row">
              <div class="col-md-6 col-sm-12">
                <div class="form-group">
                  <label>Judul Pengaduan</label>
                  <p name="peng_topik"></p>
                </div>
                <div class="form-group">
                  <label>Tanggal Pengaduan</label>
                  <p name="peng_tanggal"></p>
                </div>
              </div>
              <div class="col-md-6 col-sm-12">
                <div class="form-group">
                  <label>Instansi</label>
                  <p name="peng_instansi"></p>
                </div>
                <div class="form-group">
                  <label>Pengadu</label>
                  <p name="peng_nama"></p>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12 col-sm-12">
                <div class="form-group">
                  <label>Isi Pengaduan</label>
                  <p name="peng_isi"></p>
                </div>
              </div>
            </div>
          </div>
          
          <div id="tindakLanjut" class="tab-pane fade">
            <div class="row">
              <div class="col-md-6 col-sm-12">
                <div class="form-group">
                  <label>Penindak Lanjut</label>
                  <p name="pengtl_nama"></p>
                </div>
              </div>
              <div class="col-md-6 col-sm-12">
                <div class="form-group">
                  <label>Tanggal</label>
                  <p name="pengtl_tgl"></p>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12 col-sm-12">
                <div class="form-group">
                  <label>Tindak Lanjut</label>
                  <p name="pengtl_jawaban"></p>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-right" data-dismiss="modal">Tutup</button>
      </div>
      <!-- loading overlay -->
      <div class="overlay" style="display: none;">
        <i class="fa fa-spinner fa-spin"></i>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
