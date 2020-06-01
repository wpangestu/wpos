
<div class="row">
  <div class="col-md-12">
    <div class="box box-default" style="margin-bottom: 10px">
      <div class="box-header with-border">
        <h3 class="box-title"><i class="fa fa-id-card"></i> <?= $sub_title ?></h3>
      </div>
      <div class="box-body">
        <div class="row">
          <div class="col-md-4">
            <form action="<?= base_url('tampil_penjualan') ?>" method="post">
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
  <div class="col-md-6">
    <div class="box box-solid">
      <div class="box-header with-border">
        <h3 class="box-title"><i class="fa fa-list-ul"></i> Daftar transaksi penjualan</h3>
      </div>
      <div class="box-body">
        <h5><?= tanggal_indo2($startdate) ?> - <?= tanggal_indo2($enddate) ?></h5>
        <div class="table-responsive">
          <!-- <div class="table-responsive"> -->
          <table id="tbl_daftar" class="table table-bordered table-condensed">
            <thead>
              <tr>
                <th width="10px">No</th>
                <th>Tanggal</th>
                <th>Waktu</th>
                <th>Invoice</th>
                <th>Total</th>
                <th>Pelanggan</th>
                <!-- <th>Uang Bayar</th>
                <th>Uang Kembali</th> -->
                <!-- <th>User</th> -->
              </tr>
            </thead>
            <tbody>
              <?php $no = 1;
              foreach ($sales->result() as $sale) : ?>
                <?php $dateformat = date_create($sale->datetime_sales) ?>
                <tr class="rowtable" data-id="<?= $sale->invoice ?>" data-tgl="<?= date_format($dateformat, 'd/m/Y') ?>" data-kasir="<?= $sale->username ?>" data-jam="<?= date_format($dateformat, 'H:i') ?>" data-total="<?= rupiah($sale->total_sales) ?>" data-uangbayar="<?= rupiah($sale->pay_money) ?>" data-uangkembali="<?= rupiah($sale->refund) ?>">
                  <td><?= $no ?></td>
                  <td><?= date_format($dateformat, 'd/m/Y') ?></td>
                  <td><?= date_format($dateformat, 'H:i:s') ?></td>
                  <td><?= $sale->invoice ?></td>
                  <td class="text-right"><?= rupiah($sale->total_sales) ?></td>
                  <td><?= $sale->name_customer ?></td>
                  <!-- <td class="text-right"><?= rupiah($sale->pay_money) ?></td>
                  <td class="text-right"><?= rupiah($sale->refund) ?></td> -->
                  <!-- <td><?= $sale->username ?></td> -->
                <?php $no++;
                endforeach ?>
                <!-- <?php if ($sales->num_rows() == 0) : ?>
                <tr>
                  <td colspan="6">Data tidak ditemukan</td>
                </tr>
              <?php endif ?> -->
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-6">
    <div class="box box-solid">
      <div class="box-header with-border">
        <h3 class="box-title"><i class="fa fa-file-text-o"></i> Struk Transaksi</h3>
      </div>
      <div class="box-body">
        <h5 class="text-center">Struk Transaksi</h5>
        <div class="row">
          <div class="col-xs-12">
            <table class="table">
              <tr>
                <th>Tanggal</th>
                <td>: <span id="tanggal">-</span></td>
                <th class="text-right">Kasir</th>
                <td>: <span id="user">-</span></td>
              </tr>
              <tr>
                <th>No#</th>
                <td>: <span id="invoice">-</span></td>
                <th class="text-right">Jam</th>
                <td>: <span id="jam">-</span></td>
              </tr>
            </table>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Kode Barang</th>
                  <th>Nama Barang</th>
                  <th class="text-center">Harga</th>
                  <th class="text-center">Qty</th>
                  <th class="text-center">Diskon</th>
                  <th class="text-center">Sub Total</th>
                </tr>
              </thead>
              <tbody id="bodytable">
                <tr>
                  <td colspan="7">-</td>
                </tr>
              </tbody>
              <tfoot id="tfooter" hidden>
                <tr>
                  <th class="text-right" colspan="6">T O T A L</th>
                  <td class="text-right"><span id="totalharga"></span></td>
                </tr>
                <tr>
                  <th colspan="6" class="text-right">JUMLAH UANG</th>
                  <td class="text-right"><span id="uangbayar"></span></td>
                </tr>
                <tr>
                  <th colspan="6" class="text-right">KEMBALI</th>
                  <td class="text-right"><span id="uangkembali"></span></td>
                </tr>
                <tr>
                  <td colspan="7"><a href="#" id="btn_cetak_struct" class="btn btn-default btn-md"><i class="fa fa-print"></i> Cetak Struk</a></td>
                </tr>
              </tfoot>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>