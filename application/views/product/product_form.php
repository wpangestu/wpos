<div class="row">
    <div class="col-md-12">
        <div class="box box-solid">
            <div class="box-header with-border">
                <h3 class="box-title">
                    <a href="<?= base_url('product') ?>" class="btn btn-flat btn-xs"><i class="fa fa-arrow-left"></i></a>
                    Tambah Barang
                </h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive">
                <div id="flashdata" data-type="<?= $this->session->flashdata('type') ?>" data-message="<?= $this->session->flashdata('message') ?>"></div>
                <!-- Batas -->
                <div class="row">
                <div class="col-md-4"></div>
                    <div class="col-md-4">
                        <form id="form_add_product" action="<?php echo $action; ?>" method="post">
                            <div class="form-group">
                                <label for="varchar">Kode Barang <span class="text-danger" data-toggle="tooltip" data-placement="right" title="Wajib di isi">*</span><?php echo form_error('kode_product') ?></label>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="input-group">
                                            <input required type="text" class="form-control" name="kode_product" autofocus autocomplete="off" id="kode_product" placeholder="Kode Barang" value="<?php echo $kode_product; ?>" />
                                            <span class="input-group-btn">
                                                <button type="button" id="btn_generate_kb" class="btn <?= btncolor(getsetting()->theme) ?> btn-flat"><i class="fa fa-retweet"></i></button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="varchar">Name Barang <span class="text-danger" data-toggle="tooltip" data-placement="right" title="Wajib di isi">*</span><?php echo form_error('name_product') ?></label>
                                <input type="text" required class="form-control" name="name_product" autocomplete="off" id="name_product" placeholder="Name Product" value="<?php echo $name_product; ?>" />
                            </div>
                            <div class="form-group">
                                <label for="int">Kategori <span class="text-danger" data-toggle="tooltip" data-placement="right" title="Wajib di isi">*</span><?php echo form_error('category_id') ?></label>
                                <div class="row">
                                    <div class="col-md-6">
                                        <select required name="category_id" class="form-control select2category" id="category_id">
                                            <option value="">[ PILIH ]</option>
                                            <?php foreach ($kategori->result() as $k) : ?>
                                            <option value="<?= $k->id ?>" <?= set_value('category_id')==$k->id?'selected':'' ?>><?= $k->name ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label required for="int">Stok <span class="text-danger" data-toggle="tooltip" data-placement="right" title="Wajib di isi">*</span><?php echo form_error('stock') ?></label>
                                <div class="row">
                                    <div class="col-md-6">                            
                                        <input type="number" class="form-control" name="stock" id="stock" placeholder="Stock" value="<?php echo $stock; ?>" />
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label required for="bigint">Harga Pokok <span class="text-danger" data-toggle="tooltip" data-placement="right" title="Wajib di isi">*</span><?php echo form_error('price') ?></label>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="input-group">
                                        <span class="input-group-addon">Rp.</span>
                                        <!-- <input type="text" class="form-control" data-inputmask="&quot;mask&quot;: &quot;(999) 999-9999&quot;" data-mask=""> -->
                                        <input type="text" class="form-control price" min="0" value="0" name="price" id="price" placeholder="Price" value="<?php echo $price; ?>" />
                                    </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label required for="bigint">Harga Jual <span class="text-danger" data-toggle="tooltip" data-placement="right" title="Wajib di isi">*</span><?php echo form_error('price_sale') ?></label>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="input-group">
                                            <span class="input-group-addon">Rp.</span>
                                            <input type="text" class="form-control price" min="0" value="0" name="price_sale" id="price_sale" placeholder="Price Sale" value="<?php echo $price_sale; ?>" />
                                            <!-- <input type="text" class="form-control" placeholder="Username"> -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="bigint">Harga Jual min. 3 <?php echo form_error('price_sale_3') ?></label>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="input-group">
                                            <span class="input-group-addon">Rp.</span>
                                            <input type="text" min="0" value="0" class="form-control price" name="price_sale_3" id="price_sale_3" placeholder="Price Sale" value="<?php echo $price_sale_3; ?>" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="bigint">Harga Jual min. 5 <?php echo form_error('price_sale_5') ?></label>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="input-group">
                                            <span class="input-group-addon">Rp.</span>
                                            <input type="text" min="0" value="0" class="form-control price" name="price_sale_5" id="price_sale_5" placeholder="Price Sale" value="<?php echo $price_sale_5; ?>" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="bigint">Harga Jual min. 10 <?php echo form_error('price_sale_10') ?></label>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="input-group">
                                            <span class="input-group-addon">Rp.</span>
                                            <input type="text" min="0" value="0" class="form-control price" name="price_sale_10" id="price_sale_10" placeholder="Price Sale" value="<?php echo $price_sale_10; ?>" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="description">Deskripsi <?php echo form_error('description') ?></label>
                                <textarea class="form-control" rows="3" name="description" id="description" placeholder="Description"><?php echo $description; ?></textarea>
                                <b></b>
                            </div>
                            <button type="submit" class="btn <?= btncolor(getsetting()->theme) ?>"><i class="fa fa-send-o"></i> <?php echo $button ?></button>
                            <a href="<?php echo site_url('product') ?>" class="btn btn-default">Kembali</a>
                        </form>
                    </div>
                </div>
                <!-- Batas -->
            </div>
        </div>
    </div>
</div>


<div class="modal fade" style="z-index:9999999999999" id="md-add-category">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Tambah Data Kategori</h4>
            </div>
            <div class="modal-body">
                <form action="<?php echo base_url('category/create_action') ?>" id="quick_add_category" method="post">
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