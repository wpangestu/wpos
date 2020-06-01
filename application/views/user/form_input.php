<div class="box box-solid">
  <div class="box-header with-border">
    <h3 class="box-title">
      <a href="<?= base_url('users') ?>" class="btn btn-flat btn-xs"><i class="fa fa-arrow-left"></i></a>
      Tambah User
    </h3>
  </div>
  <!-- /.box-header -->
  <div class="box-body">
      <div class="row">
        <div class="col-md-6">
          <form action="<?= base_url('users/tambah') ?>" method="post" enctype="multipart/form-data">
            <div class="form-group">
              <label for="">Username <span class="text-danger">*</span></label>
              <input type="text" name="username" value="<?= set_value('username') ?>"class="form-control" >
              <?= form_error('username') ?>
            </div>
            <div class="form-group">
              <label for="">Nama <span class="text-danger">*</span></label>
              <input type="text" name="name" value="<?= set_value('name') ?>"class="form-control" >
              <?= form_error('name') ?>
            </div>
            <div class="form-group">
              <label for="">Password <span class="text-danger">*</span></label>
              <input type="password" name="password" class="form-control" >
              <?= form_error('password') ?>
            </div>
            <div class="form-group">
              <div class="row">
                <div class="col-md-4">
                  <label for="">Level <span class="text-danger">*</span></label>
                  <select class="form-control" name="level" id="level">
                    <option value="">--pilih--</option>
                    <option value="admin" <?= set_value('level')=='admin'?'selected':'' ?>>admin</option>
                    <option value="kasir" <?= set_value('level')=='kasir'?'selected':'' ?>>kasir</option>
                  </select>
                  <?= form_error('level') ?>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label for="">Image</label>
              <input name="image" type="file" class="dropify form-control">
            </div>
            <div class="form-group">
              <label for="">Aktif <span class="text-danger">*</span></label>
                </br>
                <input type="radio" name="is_active" value="1"class="minimal-red" checked>Ya
                &nbsp;&nbsp;
                <input type="radio" name="is_active" value="0" class="minimal-red">Tidak
               
            </div>
            <div class="form-group">
              <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
          </form>
        </div>
      </div>
  </div>
  <!-- /.box-body -->
</div>