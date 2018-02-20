<div class="modal fade" id="modal-admin" data-backdrop="static" data-keyboard="false">
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
                <label>Nama</label>
                <input type="text" name="nama" class="form-control" required="true">
              </div>
              <div class="form-group">
                <label>Level</label>
                <select name="level" class="form-control" required="true">
                  <option disabled="true" selected="selected">Pilih</option>
                  <option value="1">Super Admin</option>
                  <option value="0">Admin</option>
                </select>
              </div>
              <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" class="form-control" required="true">
              </div>
              <div class="form-group password">
                <label>Password</label>
                <input type="password" name="password" class="form-control" required="true">
              </div>
            </div>
          </div>
          {{ csrf_field() }}
    		</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Batal</button>
        <button type="button" class="btn btn-primary btn-submit" onClick="$('#modal-admin form').submit()">Simpan</button>
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
