<div class="row">
  <div class="col-md-12">
    <div class="box box-default">
      <div class="box-header with-border">
        <h3 class="box-title text-center">
          <a href="<?= base_url('transaksi/stokin') ?>" class="text-dark"><i class="fa fa-arrow-left"></i></a>
          <?= $sub_title ?>
        </h3>
      </div>
      <div class="box-body">
        <div class="row">
          <div class="col-md-4"></div>
          <div class="col-md-4">
            <form action="<?= base_url('transaction/process_stockin_add') ?>" method="POST">
              <div class="form-group">
                <label for="tangga">Tanggal <span class="text-danger">*</span></label>
                <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" required id="tgl" name="tanggal" value="<?= date('d/m/Y') ?>" class="datepicker form-control pull-right">
                </div>
              </div>
              <div class="form-group">
                <label for="id_product">Kode Barang <span class="text-danger">*</span></label>
                <div class="input-group">
                  <div class="input-group-addon">
                    <i class="glyphicon glyphicon-qrcode"></i>
                  </div>
                  <input name="kodebarang" type="text" required placeholder="Type Kode Barang" class="form-control pull-right" id="kodebarang">
                  <span class="input-group-btn">
                    <button type="button" data-toggle="modal" data-target="#itemModal" class="btn <?= btncolor(getsetting()->theme) ?>"><i class="fa fa-search"></i></button>
                  </span>
                </div>
              </div>
              <div class="form-group">
                <div class="row">
                  <div class="col-md-9">
                    <label for="name">Nama Barang</label>
                    <input type="text" required readonly name="name_product" class="form-control" id="name_product">
                  </div>
                  <div class="col-md-3">
                    <label for="">Stok</label>
                    <input type="text" required readonly name="stock_product" class="form-control" id="stock_product">
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label for="name">Keterangan <span class="text-danger">*</span></label>
                <div class="row">
                  <div class="col-md-12">
                    <textarea name="detail" required id="detail" class="form-control" cols="30" rows="2" placeholder="ex: Bonus barang"></textarea>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label for="qty">Qty <span class="text-danger">*</span></label>
                <input type="number" name="qty" required class="form-control" id="qty">
              </div>
              <div class="form-group pull-right">
                <button type="submit" class="btn <?= btncolor(getsetting()->theme) ?>"><i class="fa fa-send"></i> Simpan</button>
                <a href="<?= base_url('transaction/stock_in') ?>" class="btn btn-default btn-md">Kembali</a>
              </div>
            </form>
          </div>
          <div class="col-md-4"></div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="itemModal" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 class="modal-title" id="myModalLabel">Data Barang</h3>
      </div>
      <div class="modal-body table-responsive">
        <table class="table table-bordered table-hover table-condensed" width="100%" id="databarang">
          <thead>
            <tr>
              <th>No</th>
              <th>Kode Barang</th>
              <th>Nama Barang</th>
              <th>Stok</th>
              <th>Hrg Pokok</th>
              <th>Hrg Jual</th>
              <th>Create at</th>
              <th>Aksi</th>
            </tr>
          </thead>

        </table>
      </div>
      <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Tutup</button>
      </div>
    </div>
  </div>
</div>