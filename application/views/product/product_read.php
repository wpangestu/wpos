<div class="row">
    <div class="col-md-6">
        <div class="box box-solid">
            <div class="box-header">
                <h3 class="box-title">
                    <button onclick="window.history.go(-1)" class="btn btn-flat btn-xs"><i class="fa fa-arrow-left"></i></button>
                    Detail Barang
                </h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive">
                <div id="flashdata" data-type="<?= $this->session->flashdata('type') ?>" data-message="<?= $this->session->flashdata('message') ?>"></div>
                <!-- Batas -->
                <table class="table">
                    <tr>
                        <td>Kode Barang</td>
                        <td><?php echo $id_product; ?></td>
                    </tr>
                    <tr>
                        <td>Name Barang</td>
                        <td><?php echo $name_product; ?></td>
                    </tr>
                    <tr>
                        <td>Keterangan</td>
                        <td><?php echo $description==null?'-':$description ?></td>
                    </tr>
                    <tr>
                        <td>Stok</td>
                        <td><?php echo $stock; ?></td>
                    </tr>
                    <tr>
                        <td>Harga Pokok</td>
                        <td>Rp. <?php echo rupiah($price); ?></td>
                    </tr>
                    <tr>
                        <td>Harga Jual</td>
                        <td>Rp. <?php echo rupiah($price_sale); ?></td>
                    </tr>
                    <tr>
                        <td>Harga Jual min. 3</td>
                        <td>Rp. <?php echo rupiah($price_sale_3); ?></td>
                    </tr>
                    <tr>
                        <td>Harga Jual min. 5</td>
                        <td>Rp. <?php echo rupiah($price_sale_5); ?></td>
                    </tr>
                    <tr>
                        <td>Harga Jual min. 10</td>
                        <td>Rp. <?php echo rupiah($price_sale_10); ?></td>
                    </tr>
                    <tr>
                        <td>Kategori</td>
                        <td><?php echo $category_id; ?></td>
                    </tr>
                    <tr>
                        <td>Tanggal Input</td>
                        <td><?php echo $create_at; ?></td>
                    </tr>
                    <tr>
                        <td>Tanggal Update</td>
                        <td><?php echo $update_at; ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><a href="<?php echo site_url('product') ?>" class="btn btn-default">Cancel</a></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>