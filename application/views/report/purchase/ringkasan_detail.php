<div class="row">
  <div class="col-md-12">
    <div class="box box-default" style="margin-bottom: 10px">
      <div class="box-header with-border">
        <h3 class="box-title"><i class="fa fa-id-card"></i> <?= $sub_title ?></h3>
      </div>
      <div class="box-body">
        <div class="row">
          <div class="col-md-4">
            <form action="<?= base_url('report/purchase') ?>" method="post">
              <div class="form-group">
                <label>Range Tanggal:</label>
                <div class="input-group input-daterange">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" readonly name="startdate" id="start" value="<?= $startdate ?>" class="form-control datepicker">
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
        <h3 class="box-title"><i class="fa fa-list-ul"></i> Daftar transaksi pembelian</h3>
      </div>
      <div class="box-body">
        <h5>Transaksi Pembelian</h5>
        <p><?= tanggal_indo2($startdate) ?> - <?= tanggal_indo2($enddate) ?></p>
        <div class="table-responsive">
          <!-- <div class="table-responsive"> -->
          <table id="tbl_daftar" class="table dataTable table-bordered table-hover">
            <thead>
              <tr>
                <th width="10px">No</th>
                <th>Tanggal</th>
                <th>Waktu</th>
                <th>Invoice</th>
                <th>Supplier</th>
                <th>User</th>
                <th>Total</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php if ($purchase->num_rows() > 0) : ?>
                <?php $no = 1;
                  $total = 0;
                  foreach ($purchase->result() as $p) :
                    $total += $p->total;
                    $datetime = date_create($p->datetime_purchase);
                    ?>
                  <tr>
                    <td><?= $no ?></td>
                    <td><?= date_format($datetime, 'd/m/Y') ?></td>
                    <td><?= date_format($datetime, 'H:i:s') ?></td>
                    <td><?= $p->id_purchase ?></td>
                    <td><?= $p->name ?></td>
                    <td><?= $p->username ?></td>
                    <td class="text-right"><?= rupiah($p->total) ?></td>
                    <td>
                      <button data-tanggal="<?= date_format($datetime, 'd/m/Y') ?>" data-jam="<?= date_format($datetime, 'H:i') ?>" data-invoice="<?= $p->id_purchase ?>" data-supplier="<?= $p->name ?>" data-user="<?= $p->username ?>" class="btn btn-info btn-xs penjualan"><i class="fa fa-info-circle"></i> Detail</button>
                    </td>
                  </tr>
                <?php $no++;
                  endforeach ?>
                <tr>
                  <th class="text-right" colspan="6">T O T A L</th>
                  <td class="text-right"><?= rupiah($total) ?></td>
                  <td></td>
                </tr>
                <tr>
                  <td colspan="8"><a target="_blank" href="<?= base_url('report/print_purchase?start=' . $startdate . '&end=' . $enddate) ?>" class="btn btn-success btn-sm"><i class="fa fa-print"></i> Print Pdf</a></td>
                </tr>
              <?php else : ?>
                <tr>
                  <td colspan="8" class="bg-navy"><i class="fa fa-warning"></i> Data tidak ada</td>
                </tr>
              <?php endif ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modal-detail">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Detail Transaksi Pembelian [<span id="invoice"></span>]</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-6">
            <table class="table table-striped">
              <tr>
                <th>Tanggal</th>
                <td>: <span id="tgl"></span></td>
              </tr>
              <tr>
                <th>Supplier</th>
                <td>: <span id="supplier"></span></td>
              </tr>
            </table>
          </div>
          <div class="col-md-6">
            <table class="table table-striped">
              <tr>
                <th>User</th>
                <td>: <span id="user"></span></td>
              </tr>
              <tr>
                <th>Jam</th>
                <td>: <span id="jam"></span></td>
              </tr>
            </table>
          </div>
        </div>
        <table class="table table-bordered table-striped">
          <thead>
            <tr>
              <td>No</td>
              <td>Kode Barang</td>
              <td>Nama Barang</td>
              <td>Harga</td>
              <td>Qty</td>
              <td>Sub Total</td>
            </tr>
          </thead>
          <tbody id="bodytable">

          </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <form target="_blank" action="<?= base_url('report/print_purchase_detail') ?>" method="get">
          <input type="hidden" name="invoice" id="invoicehidden" value="">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-success"><i class="fa fa-print"></i> Print</button>
        </form>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->