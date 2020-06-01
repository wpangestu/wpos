<div id="flashdata" data-type="<?= $this->session->flashdata('type') ?>" data-message="<?= $this->session->flashdata('message') ?>"></div>
<div class="row">
  <div class="col-md-12">
    <div class="box box-default" style="margin-bottom: 10px">
      <div class="box-header with-border">
        <a href="<?= base_url('report/choose') ?>" class="fa fa-arrow-left"></a>
        <h3 class="box-title text-center"><i class="fa fa-id-card"></i> <?= $sub_title ?></h3>
      </div>
      <div class="box-body">
        <div class="form-group">
          <label for="daterange">Range Tanggal</label>
          <div class="row">
            <div class="col-md-3">
              <form action="<?= base_url('report/sell_detail') ?>" method="post">
                <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" name="tglrange" value="<?= $startdate ?> - <?= $enddate ?>" class="form-control mydaterangepicker" readonly>
                  <div class="input-group-btn">
                    <button type="submit" class="btn <?= btncolor(getsetting()->theme) ?>"><i class="fa fa-search"></i></button>
                  </div>
                  <!-- /btn-group -->
                </div>
                <!-- <input type="text" name="daterange" class="mydaterangepicker form-control" id="daterange"> -->
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="row" style="margin-top: -10px">
  <div class="col-md-12">
    <div class="box box-solid">
      <div class="box-header with-border">
        <h3 class="box-title"><i class="fa fa-list-ul"></i> Daftar transaksi penjualan</h3>
      </div>
      <div class="box-body">
        <div class="row">
          <div class="col-md-12 text-center">
            <strong>Laporan Penjualan Detail</strong>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12 text-center">
            <?php if ($startdate == $enddate) : ?>
              <?= tanggal_indo2($startdate) ?>
            <?php else : ?>
              <?= tanggal_indo2($startdate) ?> - <?= tanggal_indo2($enddate) ?>
            <?php endif ?>
          </div>
        </div>
        <div class="table-responsive">
          <table class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>No</th>
                <th>No Trans</th>
                <th>Tanggal</th>
                <th>Jam</th>
                <th>Kode Produk</th>
                <th>Nama Produk</th>
                <th>Harga Pokok</th>
                <th>Harga Jual</th>
                <th>Qty</th>
                <th>Diskon</th>
                <th>Total</th>
                <th>Laba/Rugi</th>
              </tr>
            </thead>
            <tbody>
              <?php if ($sale_detail->num_rows() > 0) : ?>
                <?php $tt = 0;
                  $tu = 0; ?>
                <?php $no = 1;
                  foreach ($sale_detail->result() as $sd) : ?>
                  <?php $datetime = date_create($sd->datetime_sales) ?>
                  <tr>
                    <td><?= $no ?></td>
                    <td><?= $sd->invoice ?></td>
                    <td><?= date_format($datetime, 'd/m/Y') ?></td>
                    <td><?= date_format($datetime, 'H:s:i') ?></td>
                    <td><?= $sd->kode_product ?></td>
                    <td><?= $sd->name_product ?></td>
                    <td class="text-right"><?= rupiah($sd->price) ?></td>
                    <?php $k = $sd->price * $sd->qty ?>
                    <td class="text-right"><?= rupiah($sd->price_sale) ?></td>
                    <td class="text-right"><?= $sd->qty ?></td>
                    <td class="text-right"><?= rupiah($sd->discount) ?></td>
                    <td class="text-right"><?= rupiah($sd->sub_total) ?></td>
                    <?php $untung = $sd->sub_total - $k ?>
                    <td class="text-right"><?= rupiah($untung) ?></td>
                  </tr>
                  <?php $tt += $sd->sub_total;
                      $tu += $untung ?>
                <?php $no++;
                  endforeach ?>
                <tr>
                  <th colspan="10" class="text-right">T O T A L :</th>
                  <td class="text-right"><?= rupiah($tt) ?></td>
                  <td class="text-right"><?= rupiah($tu) ?></td>
                </tr>
                <tr>
                  <td colspan="12">
                    <form action="<?= base_url('report/print_sell_detail') ?>" target="_blank" method="post">
                      <input type="hidden" name="start" value="<?= $startdate ?>">
                      <input type="hidden" name="end" value="<?= $enddate ?>">
                      <button type="submit" class="btn btn-danger"><i class="fa fa-print"></i> Print Pdf</button>
                      <a href="<?= base_url('report/excel_sell_detail?start='.$startdate.'&end='.$enddate) ?>" type="submit" class="btn btn-success"><i class="fa fa-file-excel-o"></i> Export Excel</a>
                    </form>
                  </td>
                </tr>
              <?php else : ?>
                <tr>
                  <td colspan="12">Data tidak ada</td>
                </tr>
              <?php endif ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>