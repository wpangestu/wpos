      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Data Pengguna</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
            <div id="flashdata" data-type="<?= $this->session->flashdata('type') ?>" data-message="<?= $this->session->flashdata('message') ?>"></div>
              <a href="<?= base_url('users/tambah') ?>" style="margin-bottom: 7px" class="btn <?= btncolor(getsetting()->theme) ?>"><i class="fa fa-plus-circle fa-lg"></i> Tambah</a>
              <table id="example1" class="table table-bordered table-hover">
                <thead>
                  <tr>
                    <th width="10px">No</th>
                    <th>Image</th>
                    <th>Username</th>
                    <th>Nama</th>
                    <th>Level</th>
                    <th class="text-center">Aktif</th>
                    <th>Date Created</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php $no=1; foreach ($users->result() as $user) : ?>
                  <tr>
                    <td><?= $no ?></td>
                    <td><img width="50px" src="<?= base_url('assets/img/'.$user->image) ?>" alt=""></td>
                    <td><?= $user->username ?></td>
                    <td><?= $user->name ?></td>
                    <td><?= $user->level ?></td>
                    <td class="text-center"><?= $user->is_active==1?'<span class="label bg-green">Ya</span>': '<span class="label label-danger">Tidak</span>' ?></td>
                    <td><?= $user->date_created ?></td>
                    <td>
                      <button type="button" class="btn bg-navy btn-xs" data-toggle="modal" title="Detail" data-target="#md-lihat-user-<?= $user->id ?>"><i class="fa fa-search"></i></button>
                      <?php if($user->level=='admin'&&$user->id==getuser()->id) : ?>
                        <a href="<?= base_url('users/ubah/'.$user->id) ?>" data-toggle="tooltip" title="Ubah" class="btn btn-xs bg-teal"><i class="fa fa-edit"></i></a>
                        <?php endif ?>
                        <?php if($user->level=='kasir') : ?>
                        <a href="<?= base_url('users/ubah/'.$user->id) ?>" data-toggle="tooltip" title="Ubah" class="btn btn-xs bg-teal"><i class="fa fa-edit"></i></a>
                        <?php if($user->is_active==1) : ?>
                          <a href="<?= base_url('users/aktifnonaktif/'.$user->id) ?>" onclick="return confirm('Apa anda yakin?')" data-toggle="tooltip" title="Non Aktifkan" class="btn btn-danger btn-xs"><i class="fa fa-ban"></i></a>
                          <?php else: ?>
                          <a href="<?= base_url('users/aktifnonaktif/'.$user->id) ?>" onclick="return confirm('Apa anda yakin?')" data-toggle="tooltip" title="Aktifkan" class="btn btn-success btn-xs"><i class="fa fa-check"></i></a>
                          <?php endif ?>
                      <?php endif ?>
                    </td>
                  </tr>
                  <?php $no++; endforeach ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
<?php foreach ($users->result() as $user) : ?>
<div class="modal fade" id="md-lihat-user-<?= $user->id ?>">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Lihat User</h4>
              </div>
              <div class="modal-body">
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
                  <td>Date Created</td><td><?= date_format($time,'d/m/Y H:i:s') ?></td>
                </tr>
              </table>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
<?php endforeach ?>
    