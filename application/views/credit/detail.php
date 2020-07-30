<div id="flashdata" data-type="<?= $this->session->flashdata('type') ?>" data-message="<?= $this->session->flashdata('message') ?>"></div>
<div class="row">
  <div class="col-md-12">
    <div class="box box-default" style="margin-bottom: 10px">
      <div class="box-header">
        <h3 class="box-title">
        <a class="text-muted" href="<?= base_url('credit') ?>"><i class="fa fa-arrow-left"></i></a>
        <i class="fa fa-id-card"></i> <?= $sub_title ?></h3>
      </div>
      <div class="box-body">
        <div class="row">
            <div class="col-md-4">
                <table class="table table-condensed table-striped table-borderless">
                    <tr>
                        <th width="30%">No Transaksi</th>
                        <td width="70%">: <?= $invoice->invoice ?></td>
                    </tr>
                    <tr>
                        <th>Tanggal</th>
                        <?php $datetime = date_create($invoice->datetime_sales) ?>
                        <td>: <?= date_format($datetime,'d-m-Y H:i') ?></td>
                    </tr>
                    <tr>
                        <th>Kasir</th>
                        <td>: <?= $invoice->username ?></td>
                    </tr>
                </table>
            </div>
            <div class="col-md-4">
                <table class="table table-condensed table-striped table-borderless">
                    <tr>
                        <th width="30%">No Pelanggan</th>
                        <td width="70%">: <?= $invoice->id_customer ?></td>
                    </tr>
                    <tr>
                        <th>Nama Pelanggan</th>
                        <td>: <?= $invoice->name_customer ?></td>
                    </tr>
                    <tr>
                        <th>Alamat</th>
                        <td>: <?= empty($invoice->address)?'-':$invoice->address ?></td>
                    </tr>
                </table>
            </div>
            <div class="col-md-4">
                <div class="well well-sm">
                    <table class="table table-striped table-condensed">
                        <tr>
                            <th width="30%">Jumlah Total</th>
                            <td width="70%">: Rp <?= rupiah($invoice->total_sales) ?></td>
                        </tr>
                        <tr>
                            <th>Total Dibayar</th>
                            <td>: Rp <?= rupiah($invoice->pay_money) ?></td>
                        </tr>
                        <tr>
                            <th>Sisa Tagihan</th>
                            <td>: Rp <?= rupiah($invoice->total_sales-$invoice->pay_money) ?></td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>: <?= $invoice->paid=="1"?'<span class="badge bg-green">LUNAS</span>':'<span class="badge bg-red">BELUM LUNAS</span>' ?> 
                            </td>
                        </tr>
                    </table>
                </div>
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
        <h3 class="box-title"><i class="fa fa-money"></i> Daftar Pembayaran</h3>
          <?php if($invoice->paid == "0") : ?>
          <button data-invoice="<?= $invoice->invoice ?>"
                  data-customer="<?= $invoice->name_customer ?>"
                  data-date="<?= date_format($datetime,'d-m-Y H:i') ?>"
                  data-total="<?= rupiah($invoice->total_sales) ?>"
                  data-dibayar="<?= rupiah($invoice->pay_money) ?>"
                  data-sisa="<?= rupiah($invoice->total_sales-$invoice->pay_money) ?>"
           id="btn_add_pay_credit" class="btn btn-sm btn-primary pull-right"><i class="fa fa-plus"></i> Tambah Pembayaran</button>
           <?php endif ?>
      </div>
      <div class="box-body">
        <div class="table-responsive">
          <!-- <div class="table-responsive"> -->
          <table id="tbl_daftar_pembayaran" class="table table-bordered table-condensed">
            <thead>
              <tr>
                <th width="10px">No</th>
                <th>Tanggal</th>
                <th>Waktu</th>
                <th>Jumlah</th>
                <th>Kasir</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php $no=1; foreach ($payment as $key => $value) : ?>
              <?php $datetime = date_create($value->created_at) ?>
                <tr>
                  <td><?= $no++; ?></td>
                  <td><?= date_format($datetime,"d-m-Y") ?></td>
                  <td><?= date_format($datetime,"H:i") ?></td>
                  <td class="text-right"><?= rupiah($value->amount) ?></td>
                  <td><?= $value->username ?></td>
                  <td class="text-center">
                    <a onclick="return confirm('Apakah anda yakin?')" href="<?= base_url('credit/delete_payment_credit/'.$value->id) ?>" class="btn btn-xs btn-danger"><i class="fa fa-times"></i></a>
                  </td>
                </tr>
              <?php endforeach ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-6">
    <div class="box box-solid">
      <div class="box-header with-border">
        <h3 class="box-title"><i class="fa fa-cube"></i> Data Barang</h3>
      </div>
      <div class="box-body">
        <div class="row">
          <div class="col-md-12">
            <div class="table-responsive">
              <table id="tbl_product" class="table table-striped">
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
                <tbody>
                  <?php $no=1; $total=0; foreach ($product->result() as $key => $value) : ?>
                    <tr>
                      <td><?= $no++; ?></td>
                      <td><?= $value->kode_product ?></td>
                      <td><?= $value->name_product ?></td>
                      <td><?= rupiah($value->price_sale) ?></td>
                      <td><?= $value->qty ?></td>
                      <td><?= $value->discount ?></td>
                      <td class="text-right"><?= rupiah($value->sub_total) ?></td>
                    </tr>
                    <?php $total += $value->sub_total ?>
                  <?php endforeach ?>
                </tbody>
                <tfoot>
                  <tr>
                    <th class="text-right" colspan="5">T O T A L</th>
                    <td class="text-right"><span id="totalharga"><?= rupiah($total) ?></span></td>
                  </tr>
                </tfoot>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="md_add_pay_credit">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Tambah Pembayaran</h4>
            </div>
            <div class="modal-body">
            <div class="row">
              <div class="col-md-4">
                    <div class="well">
                      <strong>Pelanggan</strong>: <span class="customer"></span>
                    </div>
              </div>
              <div class="col-md-4">
                <div class="well">
                    <strong>No. Trans: </strong> <span class="no_invoice"></span> 
                    <br>
                    <strong>Tanggal: </strong> <span class="date"></span>
                </div>
              </div>
              <div class="col-md-4">
                <div class="well">
                  <strong>Total: </strong> Rp<span class="total"></span><br>
                  <strong>Dibayar: </strong> Rp<span class="dibayar"></span><br>
                  <strong>Sisa: </strong> Rp<span class="sisa"></span><br>
                </div>
              </div>
                </div>
                <form action="<?php echo base_url('credit/add_payment') ?>" method="post">
                    <input type="hidden" name="invoice" id="input_invoice">
                    <div class="form-group">
                      <label>Jumlah Pembayaran</label>

                      <div class="input-group">
                        <div class="input-group-addon">
                          <i class="fa fa-money"></i>
                        </div>
                        <input type="text" data-sisa="<?= rupiah($invoice->total_sales-$invoice->pay_money) ?>" autocomplete="off" required class="form-control rupiah" name="amount" id="amount" min="100" value="0" />
                        <!-- <input type="text" class="form-control pull-right"> -->
                      </div>
                      <!-- /.input group -->
                    </div>
                    <!-- <div class="form-group">
                        <label for="varchar">Jumlah Pembayaran</label>
                        <input type="text" class="form-control" name="amount" id="amount" placeholder="Deskripsi" value="" />
                    </div> -->
                    <button type="submit" class="btn <?= btncolor(getsetting()->theme) ?>"><i class="fa fa-print"></i> Simpan & Cetak</button>
                    <button type="submit" class="btn <?= btncolor(getsetting()->theme) ?>"><i class="fa fa-send-o"></i> Simpan</button>
                    <span id="kembalian" class="pull-right"></span>
                </form>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

