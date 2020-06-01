<div id="flashdata" data-type="<?= $this->session->flashdata('type') ?>" data-message="<?= $this->session->flashdata('message') ?>"></div>
<div class="row">
  <div class="col-md-12">
    <div class="box box-default" style="margin-bottom: 10px">
      <div class="box-header with-border">
      <a href="<?= base_url('report/choose') ?>" class="fa fa-arrow-left"></a>
        <h3 class="box-title"><i class="fa fa-id-card"></i> <?= $sub_title ?></h3>
      </div>
      <div class="box-body">
        <div class="form-group">
          <label for="daterange">Range Tahun</label>
          <div class="row">
            <div class="col-md-4">
              <form action="<?= base_url('report/sale_yearly') ?>" method="post">
                <div class="input-daterange input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" name="start" value="<?= $startyear ?>" class="form-control yearpick" readonly>
                  <div class="input-group-addon">to</div>
                  <input type="text" name="end" readonly class="form-control yearpick" value="<?= $endyear ?>">
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
            <strong>Laporan Penjualan Tahunan</strong>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12 text-center">
            <?php if ($startyear == $endyear) : ?>
              <?= $startyear ?>
            <?php else : ?>
              <?= $startyear ?> - <?= $endyear ?>
            <?php endif ?>
          </div>
        </div>
        <div class="table-responsive">
          <table class="table table-bordered table-striped">
            <thead>
              <tr>
                <th width="10px">No</th>
                <th>Tahun</th>
                <!-- <th>Jumlah Modal</th> -->
                <th>Jumlah Transaksi</th>
                <th>Jumlah Laba/Rugi</th>
              </tr>
            </thead>
            <tbody>
              <?php if ($sales->num_rows() > 0) : ?>
                <?php $no = 1;
                  $total = 0;
                  $lr = 0;
                  $md = 0;
                  foreach ($sales->result() as $sale) :
                    $total += $sale->total;
                    $lr += $sale->untung;
                    $md += $sale->modal;
                    ?>
                  <tr>
                    <td><?= $no ?></td>
                    <td><?= $sale->tahun ?></td>
                    <!-- <td class="text-right"><?= rupiah($sale->modal) ?></td> -->
                    <td class="text-right"><?= rupiah($sale->total) ?></td>
                    <td class="text-right"><?= rupiah($sale->untung) ?></td>
                  </tr>
                <?php $no++;
                  endforeach ?>
            <tfoot>
              <tr>
                <th colspan="2" class="text-right">T O T A L : </th>
                <!-- <th class="text-right"><?= rupiah($md) ?></th> -->
                <th class="text-right"><?= rupiah($total) ?></th>
                <th class="text-right"><?= rupiah($lr) ?></th>
              </tr>
              <tr>
                <td colspan="5">
                  <a href="<?= base_url('report/print_sale_yearly?start='.$startyear.'&end='.$endyear) ?>" target="_blank"class="btn btn-danger"><i class="fa fa-print"></i> Print Pdf</a>
                  <a href="<?= base_url('report/excel_sale_yearly?start='.$startyear.'&end='.$endyear) ?>" type="submit" class="btn btn-success"><i class="fa fa-file-excel-o"></i> Export Excel</a>
                </td>
              </tr>
            </tfoot>
          <?php else : ?>
            <tr>
              <td colspan="4">Data tidak ada</td>
            </tr>
          <?php endif ?>
          </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>