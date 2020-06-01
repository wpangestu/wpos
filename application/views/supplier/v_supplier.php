<div id="flashdata" data-type="<?= $this->session->flashdata('type') ?>" data-message="<?= $this->session->flashdata('message') ?>"></div>
<div class="row">
  <div class="col-md-12">
    <div class="box box-default">
      <div class="box-header with-border">
        <i class="fa fa-truck"></i>

        <h3 class="box-title">Data Supplier</h3>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
        <div class="row" style="margin-bottom: 5px">
          <div class="col-md-12">
            <button data-target="#tambah-supplier" data-toggle="modal" class="btn <?= btncolor(getsetting()->theme) ?>"><i class="fa fa-plus-square"></i> Tambah</button>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12 table-responsive">
            <table id="example1" class="table table-bordered table-hover">
              <thead>
                <tr>
                  <th width="10px">No</th>
                  <th>Nama</th>
                  <th>Alamat</th>
                  <th>Telepon</th>
                  <th>Deskripsi</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php $no = 1;
                foreach ($supplier->result() as $s) : ?>
                  <tr>
                    <td><?= $no ?></td>
                    <td><?= $s->name ?></td>
                    <td><?= $s->address == null ? '-' : $s->address ?></td>
                    <td><?= $s->phone == null ? '-' : $s->phone ?></td>
                    <td><?= $s->description == null ? '-' : $s->description ?></td>
                    <?php if(getuser()->level=='admin') : ?>
                    <td>
                      <a href="#" title="ubah" 
                      data-id="<?= $s->supplier_id ?>" 
                      data-name="<?= $s->name ?>" 
                      data-address="<?= $s->address ?>" 
                      data-phone="<?= $s->phone ?>" 
                      data-desc="<?= $s->description ?>"
                      class="btn bg-teal btn-xs btn-ubah-supplier"><i class="fa fa-edit"></i> Ubah</a>
                      <a href="<?= base_url('supplier/delete/'.$s->supplier_id) ?>" onclick="return confirm('Apa anda yakin?')" title="Hapus" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> Hapus</a>
                    </td>
                    <?php else: ?>
                      <td>-</td>
                    <?php endif ?>
                  </tr>
                <?php $no++;
                endforeach ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <!-- /.box-body -->
    </div>
    <!-- /.box -->
  </div>
  <!-- /.col -->
</div>

<div class="modal fade" id="tambah-supplier">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="<?= base_url('supplier/tambah') ?>" method="post">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Tambah Supplier</h4>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label for="nama">Nama Supplier <span class="text-danger">*</span></label>
            <input autocomplete="off" type="text" name="name" required id="nama" class="form-control">
          </div>
          <div class="form-group">
            <label for="nama">Alamat</label>
            <input type="text" name="alamat" id="alamat" class="form-control">
          </div>
          <div class="form-group">
            <label for="nama">Telepon</label>
            <input type="text" name="telepon" id="telepon" class="form-control">
          </div>
          <div class="form-group">
            <label for="nama">Keterangan</label>
            <input type="text" name="keterangan" id="keterangan" class="form-control">
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn <?= btncolor(getsetting()->theme) ?>"><i class="fa fa-send-o"></i> Simpan</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- UBAH MODAL -->
<div class="modal fade" id="ubah-supplier">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="<?= base_url('supplier/update') ?>" method="post">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Ubah Supplier</h4>
        </div>
        <div class="modal-body">
          <input type="hidden" name="id" id="supp_id">
          <div class="form-group">
            <label for="nama">Nama Supplier <span class="text-danger">*</span></label>
            <input autocomplete="off" type="text" name="name" required id="supp_nama" class="form-control">
          </div>
          <div class="form-group">
            <label for="nama">Alamat</label>
            <input type="text" name="alamat" id="supp_alamat" class="form-control">
          </div>
          <div class="form-group">
            <label for="nama">Telepon</label>
            <input type="text" name="telepon" id="supp_telepon" class="form-control">
          </div>
          <div class="form-group">
            <label for="nama">Keterangan</label>
            <input type="text" name="keterangan" id="supp_keterangan" class="form-control">
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn <?= btncolor(getsetting()->theme) ?>"><i class="fa fa-send-o"></i> Simpan</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
        </div>
      </form>
    </div>
  </div>
</div>