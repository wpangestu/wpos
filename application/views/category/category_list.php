<div class="row">
    <div class="col-md-12">
        <div class="box box-default">
            <div class="box-header with-border">
                <i class="fa fa-inbox"></i>

                <h3 class="box-title"><?= $sub_title ?></h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <!-- BATAS TEMPLATE -->
                <div id="flashdata" data-type="<?= $this->session->flashdata('type') ?>" data-message="<?= $this->session->flashdata('message') ?>"></div>

                <div class="row" style="margin-bottom: 10px">
                    <div class="col-md-4">
                        <!-- <?php echo anchor(site_url('category/create'), 'Tambah', 'class="btn btn-primary"'); ?> -->
                        <button data-target="#md-add-category" data-toggle="modal" class="btn <?= btncolor(getsetting()->theme) ?>"><i class="fa fa-plus-square"></i> Tambah</button>
                    </div>
                    <div class="col-md-4 text-center">
                    </div>
                    <div class="col-md-1 text-right">
                    </div>
                    <div class="col-md-3 text-right">
                        <form action="<?php echo site_url('category/index'); ?>" class="form-inline" method="get">
                            <div class="input-group">
                                <input type="text" class="form-control" name="q" value="<?php echo $q; ?>">
                                <span class="input-group-btn">
                                    <?php
                                    if ($q <> '') {
                                        ?>
                                        <a href="<?php echo site_url('category'); ?>" class="btn btn-default">Reset</a>
                                    <?php
                                    }
                                    ?>
                                    <button class="btn btn-primary" type="submit">Search</button>
                                </span>
                            </div>
                        </form>
                    </div>
                </div>
                <?php echo validation_errors(); ?>
                <table class="table table-bordered" style="margin-bottom: 10px">
                    <tr>
                        <th width="5%">No</th>
                        <th>Name</th>
                        <th>Keterangan</th>
                        <th>Created</th>
                        <th>Updated</th>
                        <th>Action</th>
                    </tr><?php
                        foreach ($category_data as $category) {
                            ?>
                        <tr>
                            <td width="80px"><?php echo ++$start ?></td>
                            <td><?php echo $category->name ?></td>
                            <td><?php echo $category->description == null ? '-' : $category->description ?></td>
                            <td><?php echo $category->created ?></td>
                            <td><?php echo $category->updated ?></td>
                            <td style="text-align:center" width="200px">
                                <?php if(getuser()->level=="admin") : ?>
                                    <button type="button" data-id="<?= $category->id ?>" data-kategori="<?= $category->name ?>" data-desc="<?= $category->description ?>" class="btn btn-xs bg-teal edit-category"><i class="fa fa-edit"></i> Ubah</button>
                                    <?php echo anchor(site_url('category/delete/' . $category->id), '<i class="fa fa-trash"></i> Hapus', 'class="btn btn-xs btn-danger" onclick="javasciprt: return confirm(\'Apa anda yakin ?\')"'); ?>
                                <?php else: ?>
                                    -
                                <?php endif ?>
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
                <!-- Batas Template -->
            </div>
        </div>
    </div>
</div>

<!-- MODAL TAMBAH -->
<div class="modal fade" id="md-add-category">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Tambah Data Kategori</h4>
            </div>
            <div class="modal-body">
                <form action="<?php echo base_url('category/create_action') ?>" method="post">
                    <div class="form-group">
                        <label for="varchar">Kategori Produk <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="name" id="name" placeholder="kategori" required value="" />
                    </div>
                    <div class="form-group">
                        <label for="varchar">Deskripsi</label>
                        <input type="text" class="form-control" name="deskripsi" id="deskripsi" placeholder="Deskripsi" value="" />
                    </div>
                    <button type="submit" class="btn <?= btncolor(getsetting()->theme) ?>"><i class="fa fa-send-o"></i> Simpan</button>
                </form>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="md-ubah-category">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Ubah Data Kategori</h4>
            </div>
            <div class="modal-body">
                <form action="<?php echo base_url('category/update_action') ?>" method="post">
                    <input type="hidden" name="idkategori" id="idkategori">
                    <div class="form-group">
                        <label for="varchar" >Kategori Produk <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="name" id="name_category" placeholder="kategori" required value="" />
                    </div>
                    <div class="form-group">
                        <label for="varchar">Deskripsi</label>
                        <input type="text" class="form-control" name="deskripsi" id="deskripsi_category" placeholder="Deskripsi" value="" />
                    </div>
                    <button type="submit" class="btn <?= btncolor(getsetting()->theme) ?>"><i class="fa fa-send-o"></i> Simpan</button>
                </form>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>