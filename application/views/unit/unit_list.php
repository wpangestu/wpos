<div class="row">
    <div class="col-md-12">
        <div class="box box-default">
            <div class="box-header with-border">
                <i class="fa fa-truck"></i>

                <h3 class="box-title"><?= $sub_title ?></h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div id="flashdata" data-type="<?= $this->session->flashdata('type') ?>" data-message="<?= $this->session->flashdata('message') ?>"></div>
                <!-- Batas -->
                <div class="row" style="margin-bottom: 10px">
                    <div class="col-md-4">
                        <button data-target="#md-add-unit" data-toggle="modal" class="btn btn-primary">Tambah</button>                        
                    </div>
                    <div class="col-md-4"></div>
                    <div class="col-md-1 text-right">
                   
                    </div>
                    <div class="col-md-3 text-right">
                        <form action="<?php echo site_url('unit/index'); ?>" class="form-inline" method="get">
                            <div class="input-group">
                                <input type="text" class="form-control" name="q" value="<?php echo $q; ?>">
                                <span class="input-group-btn">
                                    <?php
                                    if ($q <> '') {
                                        ?>
                                    <a href="<?php echo site_url('unit'); ?>" class="btn btn-default">Reset</a>
                                    <?php
                                    }
                                    ?>
                                    <button class="btn btn-primary" type="submit">Search</button>
                                </span>
                            </div>
                        </form>
                    </div>
                </div>
                <table class="table table-bordered" style="margin-bottom: 10px">
                    <tr>
                        <th>No</th>
                        <th>Kode Unit</th>
                        <th>Name</th>
                        <th>Created</th>
                        <th>Updated</th>
                        <th>Action</th>
                    </tr><?php
                            foreach ($unit_data as $unit) {
                                ?>
                    <tr>
                        <td width="80px"><?php echo ++$start ?></td>
                        <td><?php echo $unit->kode_unit ?></td>
                        <td><?php echo $unit->name==null?'-':$unit->name ?></td>
                        <td><?php echo $unit->created ?></td>
                        <td><?php echo $unit->updated ?></td>
                        <td style="text-align:center" width="200px">
                                <button class="btn btn-xs btn-flat btn-primary edit-unit" data-id="<?= $unit->id ?>" data-kode="<?= $unit->kode_unit ?>" data-ket="<?= $unit->name ?>">Ubah</button>
                                <?php echo anchor(site_url('unit/delete/' . $unit->id), 'Delete', 'class="btn btn-xs btn-flat btn-danger" onclick="javasciprt: return confirm(\'Are You Sure ?\')"');
                                ?>
                        </td>
                    </tr>
                    <?php
                    }
                    ?>
                </table>
                <div class="row">
                    <div class="col-md-6">
                        <a href="#" class="btn btn-primary">Total Record : <?php echo $total_rows ?></a>
                    </div>
                    <div class="col-md-6 text-right">
                        <?php echo $pagination ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

  <!-- MODAL TAMBAH -->
  <div class="modal fade" id="md-add-unit">
      <div class="modal-dialog">
          <div class="modal-content">
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">×</span></button>
                  <h4 class="modal-title">Tambah Unit</h4>
              </div>
              <div class="modal-body">
                  <form action="<?php echo base_url('unit/create_action') ?>" method="post">
                      <div class="form-group">
                          <label for="varchar" class="text-red">Kode Unit Produk</label>
                          <input type="text" class="form-control" name="kode_unit" id="kode_unit" placeholder="pcs, kg, ..." required value="" />
                      </div>
                      <div class="form-group">
                          <label for="varchar">Keterangan</label>
                          <input type="text" class="form-control" name="name" id="name" placeholder="Keterangan" value="" />
                      </div>
                      <button type="submit" class="btn btn-primary">Simpan</button>
                  </form>
              </div>
          </div>
          <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
  </div>

  <div class="modal fade" id="md-ubah-unit">
      <div class="modal-dialog">
          <div class="modal-content">
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">×</span></button>
                  <h4 class="modal-title">Ubah Unit</h4>
              </div>
              <div class="modal-body">
                  <form action="<?php echo base_url('unit/update_action') ?>" method="post">
                      <input type="hidden" name="idunit" id="idunit">
                        <div class="form-group">
                          <label for="varchar" class="text-red">Kode Unit</label>
                          <input type="text" class="form-control" name="kode_unit" id="kode_unit_produk" placeholder="kg, pcs, ..." required value="" />
                      </div>
                      <div class="form-group">
                          <label for="varchar">Keterangan</label>
                          <input type="text" class="form-control" name="name" id="name_unit" placeholder="Deskripsi" value="" />
                      </div>
                      <button type="submit" class="btn btn-primary">Ubah</button>
                  </form>
              </div>
          </div>
          <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
  </div>