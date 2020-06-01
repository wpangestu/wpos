<div class="box box-solid">
  <div class="box-header with-border">
    <h3 class="box-title">
      <a href="<?= base_url('users') ?>" class="btn btn-flat btn-xs"><i class="fa fa-arrow-left"></i></a>
      Ubah User
    </h3>
  </div>
  <!-- /.box-header -->
  <div class="box-body">
      <div class="row">
        <div class="col-md-6">
          <form action="<?= base_url('users/proses_ubah') ?>" method="post" enctype="multipart/form-data">
            <div class="form-group">
              <label for="">Username</label>
              <input type="text" readonly name="username" value="<?= $user->username ?>" class="form-control" >
            </div>
            <!-- <div class="form-group">
              <label for="">Username Baru (Biarkan jika tidak ingin diubah)</label>
              <input type="text" name="username_baru" placeholder="<?= $user->username ?>" value="" class="form-control" >
            </div> -->
            <div class="form-group">
              <label for="">Nama</label>
              <input type="text" name="name" required value="<?= $user->name ?>" class="form-control" >
            </div>
            <div class="form-group">
              <label for="">Password (Biarkan jika tidak ingin diubah)</label>
              <input type="password" name="password" class="form-control" >
            </div>
            <div class="form-group">
              <div class="row">
                <div class="col-md-4">
                  <label for="">Level</label>
                  <select class="form-control" name="level" id="level">
                    <option value="">--pilih--</option>
                    <option value="admin" <?= $user->level=='admin'?'selected':'' ?>>admin</option>
                    <option value="kasir" <?= $user->level=='kasir'?'selected':'' ?>>kasir</option>
                  </select>
            
                </div>
              </div>
            </div>
            <div class="form-group">
              <label for="">Image</label> [Biarkan jika tidak ingin diubah]
              <input name="image" type="file" data-default-file="<?= base_url('assets/img/'.$user->image) ?>" class="dropify form-control">
            </div>
            <div class="form-group">
              <label for="">Aktif</label>
                </br>
                <input type="radio" name="is_active" value="1"class="minimal-red" <?= $user->is_active==1?'checked':'' ?>>Ya
                &nbsp;&nbsp;
                <input type="radio" name="is_active" value="0" class="minimal-red" <?= $user->is_active==0?'checked':'' ?>>Tidak   
            </div>
            <div class="form-group">
              <button type="submit" class="btn <?= btncolor(getsetting()->theme) ?>"><i class="fa fa-send-o"></i> Simpan</button>
            </div>
          </form>
        </div>
      </div>
  </div>
  <!-- /.box-body -->
</div>