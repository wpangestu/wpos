<div class="row">
    <div class="col-md-12">
        <div class="box box-default">
            <div class="box-header with-border">
                <i class="fa fa-cube"></i>

                <h3 class="box-title"><?= $sub_title ?></h3>
            </div>
            <!-- /.box-header -->
            <div style="overflow:scroll" class="box-body table-responsive">
                <div id="flashdata" data-type="<?= $this->session->flashdata('type') ?>" data-message="<?= $this->session->flashdata('message') ?>"></div>
                <!-- Batas -->
                <div class="row" style="margin-bottom: 10px">
                    <div class="col-md-4">
                        <!-- <?php echo anchor(site_url('product/create'), '<i class="fa fa-plus-square fa-lg fa-fw"></i> Tambah data barang', 'class="btn <?= btncolor(getsetting()->theme) ?>"'); ?> -->
                        <a href="<?= base_url('product/create') ?>" class="btn <?= btncolor(getsetting()->theme) ?>"><i class="fa fa-plus-square fa-lg fa-fw"></i> Tambah data barang</a>
                    </div>
                    <div class="col-md-4"></div>
                    <div class="col-md-4">
                        <?php echo anchor(site_url('report/excel_product'), '<i class="fa fa-file-excel-o"></i> Export Excel', 'class="pull-right btn btn-success"'); ?>
                        <!-- <?php echo anchor(site_url('product/excel'), 'Pdf', 'class="pull-right btn btn-success"'); ?> -->
                    </div>
                </div>
                <table class="table display no-wrap table-bordered table-condensed table-striped nowrap" id="mytable">
                    <thead>
                        <tr>
                            <th width="20px">No</th>
                            <th><span data-toggle="tooltip" title="Kode Barang">Kode Brg</span></th>
                            <th><span data-toggle="tooltip" title="Nama Barang">Nama Brg</span></th>
                            <th><span data-toggle="tooltip" title="Stok Barang">Stok</th>
                            <th class="text-center"><span data-toggle="tooltip" title="Harga Pokok">Hrg Pokok</th>
                            <th class="text-center"><span data-toggle="tooltip" title="Harga Jual">Hrg Jual</th>
                            <th class="text-center"><span data-toggle="tooltip" title="Harga Jual">Hrg Jual 3</th>
                            <th class="text-center"><span data-toggle="tooltip" title="Harga Jual">Hrg Jual 5</th>
                            <th class="text-center"><span data-toggle="tooltip" title="Harga Jual">Hrg Jual 10</th>
                            <th><span data-toggle="tooltip" title="Kategori">Kategori</th>
                            <th><span data-toggle="tooltip" title="Tanggal Masuk">Update</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>