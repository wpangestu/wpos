<!-- <div class="row">
  <div class="col-md-12">
      <div class="box box-solid">
      <div class="box-header with-border">
        <h3 class="box-title">My Profile</h3>
      </div>
      <div class="box-body">
        <div class="row">
          <div class="col-md-6">
            <table class="table table-striped table-bordered">
              <tr>
                <td></td><td><img width="150px" src="<?= base_url('assets/img/'.$user->image) ?>" alt=""></td>
              </tr>
              <tr>
                <td>Username</td><td><?= $user->username ?></td>
              </tr>
              <tr>
                <td>Nama</td><td><?= $user->name ?></td>
              </tr>
              <tr>
                <td>Level</td><td><?= $user->level ?></td>
              </tr>
              <tr>
                <td>Status</td><td><?= $user->is_active==1?'aktif':'tidak aktif' ?></td>
              </tr>
              <tr>
                <?php $time = date_create($user->date_created) ?>
                <td>Date Created</td><td><?= date_format($time,'d/m/Y H:m:i') ?></td>
              </tr>
            </table>
          </div>
          <div class="col-md-6">
          </div>
        </div>  
      </div>
    </div>
  </div>
</div> -->

<div class="row">
  <div class="col-md-12">
  <div class="nav-tabs-custom">
      <ul class="nav nav-tabs">
        <li <?= $tab==1?'class="active"':'' ?>><a href="#tab_1" data-toggle="tab">Profil Saya</a></li>
        <li <?= $tab==2?'class="active"':'' ?>><a href="#tab_2" data-toggle="tab">Ubah Profil</a></li>
      </ul>
      <div class="tab-content">
        <div class="tab-pane <?= $tab==1?'active':'' ?>" id="tab_1">
          <div class="row">
            <div class="col-md-6">
              <table class="table table-striped table-bordered">
                <tr>
                  <td></td><td><img width="150px" src="<?= base_url('assets/img/'.$user->image) ?>" alt=""></td>
                </tr>
                <tr>
                  <td>Username</td><td><?= $user->username ?></td>
                </tr>
                <tr>
                  <td>Nama</td><td><?= $user->name ?></td>
                </tr>
                <tr>
                  <td>Level</td><td><?= $user->level ?></td>
                </tr>
                <tr>
                  <td>Status</td><td><?= $user->is_active==1?'aktif':'tidak aktif' ?></td>
                </tr>
                <tr>
                  <?php $time = date_create($user->date_created) ?>
                  <td>Date Created</td><td><?= date_format($time,'d/m/Y H:m:i') ?></td>
                </tr>
              </table>
            </div>
          </div>
        </div>
        <!-- /.tab-pane -->
        <div class="tab-pane <?= $tab==2?'active':'' ?>" id="tab_2">
          <div class="row">
            <div class="col-md-6">
              <form action="<?= base_url('profile/update') ?>" method="post" enctype="multipart/form-data">
                <div class="form-group">
                  <label for="">Username Saat ini</label> <?= form_error('username') ?>
                  <input type="text" readonly name="username" class="form-control" required value="<?=$user->username?>">
                </div>
                <div class="form-group">
                  <label for="">Username baru (Biarkan jika tidak ingin diubah)</label>
                  <input type="text" name="username_new" class="form-control" value="<?= set_value('username_new') ?>">
                  <?= form_error('username_new') ?>
                </div>
                <div class="form-group">
                  <label for="">Nama</label> 
                  <input type="text" name="name" required class="form-control" value="<?= form_error('name')==null? $user->name: set_value('name') ?>">
                  <?= form_error('name') ?>
                </div>
                <div class="form-group">
                  <label for="">Password </label><small> (kosongkan jika tidak ingin diubah)</small>
                  <input type="password" name="password" class="form-control" value="<?= set_value('password') ?>">
                  <?= form_error('password') ?>
                </div>
                <div class="form-group">
                  <label for="">Image</label> <?= form_error('image') ?>
                  <input type="file" name="image" class="dropify form-control" data-default-file="<?= base_url('assets/img/'.$user->image) ?>">
                </div>
                <div class="form-group">
                  <button type="submit" class="btn <?= btncolor(getsetting()->theme) ?>"><i class="fa fa-send-o"></i> Simpan</button>
                </div>
              </form>
            </div>
          </div>
        </div>
        <!-- /.tab-pane -->
      </div>
      <!-- /.tab-content -->
    </div>
  </div>
</div>