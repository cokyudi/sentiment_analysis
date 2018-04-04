<div class="modal fade" id="modal-pengetahuan" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header red">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title"></h4>
      </div>
      <div class="modal-body">
    	<form>
          <div class="row">
            <div class="col-sm-12">
              <div class="form-group">
                <label>Kata</label>
                <input type="text" name="kata" class="form-control" required="true">
              </div>
            </div>
            <div class="col-sm-12">
              <div class="form-group">
                <label>Frekuensi</label>
                <input type="text" name="frekuensi" class="form-control" required="true">
              </div>
            </div>
            <div class="col-sm-12">
              <div class="form-group">
                <label>Chisquare</label>
                <input type="text" name="n_chisquare" class="form-control" required="true">
              </div>
            </div>
            <div class="col-sm-12">
              <div class="form-group">
                <label>Netral</label>
                <input type="text" name="n_netral" class="form-control" required="true">
              </div>
            </div>
            <div class="col-sm-12">
              <div class="form-group">
                <label>Positif</label>
                <input type="text" name="n_positif" class="form-control" required="true">
              </div>
            </div>
            <div class="col-sm-12">
              <div class="form-group">
                <label>Negatif</label>
                <input type="text" name="n_negatif" class="form-control" required="true">
              </div>
            </div>
          </div>
          {{ csrf_field() }}
    	</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Batal</button>
        <button type="button" class="btn btn-primary btn-submit" onClick="$('#modal-pengetahuan form').submit()">Simpan</button>
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
