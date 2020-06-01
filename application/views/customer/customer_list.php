<div id="flashdata" data-type="<?= $this->session->flashdata('type') ?>" data-message="<?= $this->session->flashdata('message') ?>"></div>
<div class="row">
    <div class="col-md-12">
        <div class="box box-red">
            <div class="box-header with-border">
                <i class="fa fa-list"></i>

                <h3 class="box-title"><?= $sub_title ?></h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <!-- BATAS TEMPLATE -->
                <div class="row" style="margin-bottom: 10px">
                    <div class="col-md-4">
                        <button data-toggle="modal" data-target="#tambah-customer" class="btn <?= btncolor(getsetting()->theme) ?>"><i class="fa fa-plus-square"></i> Tambah</button>
                    </div>
                </div>
                <table class="table table-bordered table-striped" id="mytable">
                    <thead>
                        <tr>
                            <th width="10px">No</th>
                            <th>Kode Pelanggan</th>
                            <th>Name Pelanggan</th>
                            <th>Jenis Kelamin</th>
                            <th>Alamat</th>
                            <th>Telepon</th>
                            <th>Total Belanja</th>
                            <th>Update At</th>
                            <th width="200px">Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="tambah-customer">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Tambah Pelanggan</h4>
        </div>
        <div class="modal-body">
            <form action="<?= base_url('customer/create_action') ?>" method="post">
                <div class="form-group">
                    <label for="varchar">Kode Pelanggan <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" value="<?= $newid ?>" name="id_customer" id="id_customer" required placeholder="Id Customer" />
                </div>
                <div class="form-group">
                    <label for="varchar">Nama Pelanggan <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="name_customer" id="name_customer" required placeholder="Name Customer" />
                </div>
                <div class="form-group">
                    <label for="enum">Jenis Kelamin <span class="text-danger">*</span></label>
                    <!-- <input type="text" class="form-control" name="gender" id="gender" required placeholder="Gender" /> -->
                    <select name="gender" class="form-control" id="gender" required>
                        <option value="">Pilih</option>
                        <option value="l">Laki-laki</option>
                        <option value="p">Perempuan</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="address">Alamat</label>
                    <textarea class="form-control" rows="3" name="address" id="address" placeholder="Address"></textarea>
                </div>
                <div class="form-group">
                    <label for="varchar">Telephone</label>
                    <input type="text" class="form-control" name="phone" id="phone" placeholder="Phone" />
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn <?= btncolor(getsetting()->theme) ?>"><i class="fa fa-send-o"></i> Simpan</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                </div>
            </form>
        </div>
        </div>
    </div>
</div>

<div class="modal fade" id="ubah-customer">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Ubah Pelanggan</h4>
        </div>
        <div class="modal-body">
            <form action="<?= base_url('customer/update_action') ?>" method="post">
                <input type="hidden" name="id" id="cust_id">
                <div class="form-group">
                    <label for="varchar">Kode Pelanggan <span class="text-danger">*</span></label>
                    <input type="text" readonly class="form-control" name="id_customer" id="cust_id_customer" required placeholder="Id Customer" />
                </div>
                <div class="form-group">
                    <label for="varchar">Nama Pelanggan <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="name_customer" id="cust_name_customer" required placeholder="Name Customer" />
                </div>
                <div class="form-group">
                    <label for="enum">Jenis Kelamin <span class="text-danger">*</span></label>
                    <select name="gender" class="form-control" id="custgender">
                        <!-- <option value="l">Laki-laki</option>
                        <option value="p">Perempuan</option> -->
                    </select>
                </div>
                <div class="form-group">
                    <label for="address">Alamat</label>
                    <textarea class="form-control" rows="3" name="address" id="cust_address" placeholder="Address"></textarea>
                </div>
                <div class="form-group">
                    <label for="varchar">Telephone</label>
                    <input type="text" class="form-control" name="phone" id="cust_phone" placeholder="Phone" />
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn <?= btncolor(getsetting()->theme) ?>"><i class="fa fa-send-o"></i> Simpan</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                </div>
            </form>
        </div>
        </div>
    </div>
</div>