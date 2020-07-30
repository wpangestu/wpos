<div class="row">
  <div class="col-md-12">
    <div class="box box-default" style="margin-bottom: 10px">
      <div class="box-header with-border">
        <h3 class="box-title"><i class="fa fa-id-card"></i> <?= $sub_title ?></h3>
      </div>
      <div class="box-body">
        <div class="row">
          <div class="col-md-4">
            <form action="<?= base_url('credit') ?>" method="get">
              <div class="form-group">
                <label>Range Tanggal:</label>
                <div class="input-group input-daterange">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" readonly name="startdate" id="start" class="form-control datepicker" value="<?= $startdate ?>">
                    <div class="input-group-addon"> - </div>
                  <input type="text" readonly name="enddate" id="end" class="form-control datepicker" value="<?= $enddate ?>">
                  <span class="input-group-btn">
                    <button type="submit" class="btn <?= btncolor(getsetting()->theme) ?> btn-flat">Tampil</button>
                  </span>
                </div>
              </div>
            </form>
          </div>
          <div class="col-md-4">
            <!-- <div class="form-group">
          <label>Range Tanggal:</label>

          <div class="input-group">
            <div class="input-group-addon">
              <i class="fa fa-calendar"></i>
            </div>
            <input type="text" readonly class="form-control" id="rangetgl">
            <span class="input-group-btn">
              <button type="button" class="btn btn-info btn-flat">Go!</button>
            </span>
          </div>
        </div> -->
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
        <h3 class="box-title"><i class="fa fa-list-ul"></i> Daftar transaksi hutang | <?= tanggal_indo2($startdate) ?> - <?= tanggal_indo2($enddate) ?></h3>
      </div>
      <div class="box-body">
        <h5></h5>
        <div class="table-responsive">
          <!-- <div class="table-responsive"> -->
          <table id="tbl_daftar_credit" class="table table-bordered table-condensed">
            <thead>
              <tr>
                <th width="1%">No</th>
                <th width="5%">Tanggal</th>
                <th width="10%">No Transaksi</th>
                <th width="20%">Pelanggan</th>
                <th class="text-center" width="10%">Jumlah Total</th>
                <th class="text-center" width="10%">Total dibayar</th>
                <th class="text-center" width="10%">Status</th>
                <th width="5%">Aksi</th>
                <!-- <th>Uang Bayar</th>
                <th>Uang Kembali</th> -->
                <!-- <th>User</th> -->
              </tr>
            </thead>
            <tbody>
              <?php $no = 1;
              foreach ($credit->result() as $sale) : ?>
                <?php $dateformat = date_create($sale->datetime_sales) ?>
                <tr data-id="<?= $sale->invoice ?>" data-tgl="<?= date_format($dateformat, 'd/m/Y') ?>" data-kasir="<?= $sale->username ?>" data-jam="<?= date_format($dateformat, 'H:i') ?>" data-total="<?= rupiah($sale->total_sales) ?>" data-uangbayar="<?= rupiah($sale->pay_money) ?>" data-uangkembali="<?= rupiah($sale->refund) ?>">
                  <td><?= $no ?></td>
                  <td><?= date_format($dateformat, 'd/m/Y H:i') ?></td>
                  <td><?= $sale->invoice ?></td>
                  <td><?= $sale->name_customer ?></td>
                  <td class="text-right"><?= rupiah($sale->total_sales) ?></td>
                  <td class="text-right"><?= rupiah($sale->pay_money) ?></td>
                  <td class="text-center">
                    <?= $sale->total_sales==$sale->pay_money?'<span class="label label-success">Lunas</span>':'<span class="label label-danger">Belum Lunas</span>' ?>
                  </td>
                  <td><a href="<?= base_url('credit/invoice/'.$sale->invoice) ?>" class="btn btn-xs btn-primary">Detail</a></td>
                <?php $no++;
                endforeach ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>