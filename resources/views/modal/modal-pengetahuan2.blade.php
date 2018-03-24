<div class="modal fade" id="modal-pengetahuan-2" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header red">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"></h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-sm-12">
            <div class="form-group">
              <label>Kata</label>
              <p name="kata"></p>
            </div>
          </div>
          <div class="col-sm-12">
            <div class="form-group">
              <label>Nilai</label>
              <p name="nilai"></p>
            </div>
          </div>
        </div>
        <form>
          {{ csrf_field() }}
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Batal</button>
        <button type="button" class="btn btn-primary btn-submit" onClick="$('#modal-pengetahuan-2 form').submit()">Ya</button>
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
