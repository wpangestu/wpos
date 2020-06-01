<div id="flashdata" data-type="<?= $this->session->flashdata('type') ?>" data-message="<?= $this->session->flashdata('message') ?>"></div>
<div class="row">
  <div class="col-md-12">
    <div class="box box-default" style="margin-bottom: 10px">
      <div class="box-header with-border">
      <a href="<?= base_url('report/sell_bycustomer/') ?>" class="fa fa-arrow-left"></a>
        <h3 class="box-title"><i class="fa fa-id-card"></i> <?= $sub_title ?></h3>
      </div>
      <div class="box-body">
        <div class="form-group">
          <label for="daterange">Range Bulan</label>
          <div class="row">
            <div class="col-md-4">
              <form action="<?= base_url('report/sell_customer_detail/'.$kode) ?>" method="post">
                <div class="input-daterange input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" name="start" value="<?= $startmonth ?>" class="form-control monthpick" readonly>
                  <div class="input-group-addon">to</div>
                  <input type="text" name="end" class="form-control monthpick" value="<?= $endmonth ?>">
                  <div class="input-group-btn">
                    <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php $data = $sales->result() ?>

<div class="row" style="margin-top: -10px">
  <div class="col-md-12">
    <div class="box box-solid">
      <div class="box-header with-border">
        <h3 class="box-title"><i class="fa fa-list-ul"></i> Penjualan detail [<?= $kode ?> - <?= $pelanggan->name_customer ?>]</h3>
      </div>
      <div class="box-body">
        <div class="row">
          <div class="col-md-12 text-center">
            <strong>Laporan Penjualan Detail</strong>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12 text-center">
            <strong>| <?= $kode ?> - <?= $pelanggan->name_customer ?> |</strong>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12 text-center">
            <strong></strong>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12 text-center">
            <?php if ($startmonth == $endmonth) : ?>
              <?= bulan_indo2($startmonth) ?>
            <?php else : ?>
              <?= bulan_indo2($startmonth) ?> - <?= bulan_indo2($endmonth) ?>
            <?php endif ?>
          </div>
        </div>
        <div class="table-responsive">
          <table class="table table-bordered table-striped">
            <thead>
              <tr>
                <th width="10px">No</th>
                <!-- <th>Kode Pelanggan</th>
                <th>Nama Pelanggan</th> -->
                <th>Bulan</th>
                <!-- <th>Jumlah Modal</th> -->
                <th>Jumlah Transaksi</th>
              </tr>
            </thead>
            <tbody>
              <?php if ($sales->num_rows() > 0) : ?>
                <?php $no = 1;
                  $total = 0;
                  foreach ($sales->result() as $sale) :
                    $total += $sale->total;
                    $datetime = date_create($sale->bulan);
                    ?>
                  <tr>
                    <td><?= $no ?></td>
                    <!-- <td><?= $sale->id_customer ?></td>
                    <td><?= $sale->name_customer ?></td> -->
                    <td><?= bulan_indo2(date_format($datetime, 'm/Y')) ?></td>
                    <!-- <td class="text-right"><?= rupiah($sale->modal) ?></td> -->
                    <td class="text-right"><?= rupiah($sale->total) ?></td>
                  </tr>
                <?php $no++;
                  endforeach ?>
            <tfoot>
              <tr>
                <th colspan="2" class="text-right">T O T A L : </th>
                <!-- <th class="text-right"><?= rupiah($md) ?></th> -->
                <th class="text-right"><?= rupiah($total) ?></th>
              </tr>
              <!-- <tr>
                <td colspan="5">
                  <a href="<?= base_url('report/print_sale_monthly?start='.$startmonth.'&end='.$endmonth) ?>" target="_blank"class="btn btn-danger"><i class="fa fa-print"></i> Print Pdf</a>
                  <a href="<?= base_url('report/excel_sale_monthly?start='.$startmonth.'&end='.$endmonth) ?>" type="submit" class="btn btn-success"><i class="fa fa-file-excel-o"></i> Export Excel</a>
                </td>
              </tr> -->
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