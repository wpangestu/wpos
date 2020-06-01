<div id="flashdata" data-type="<?= $this->session->flashdata('type') ?>" data-message="<?= $this->session->flashdata('message') ?>"></div>
<div class="row">
  <div class="col-md-12">
    <div class="box box-default">
      <div class="box-header with-border">
        <h3 class="box-title"><i class="fa fa-opencart"></i> <?= $sub_title ?></h3>
      </div>
      <div class="box-body">
        <form action="<?= base_url('transaction/process_purchase') ?>" method="post" class="form-horizontal">
          <div class="row">
            <div class="col-md-3">
              <div class="form-group">
                <label for="inputEmail3" class="col-sm-3 control-label">Tanggal</label>
                <div class="col-sm-9">
                  <input type="text" readonly class="form-control" name="tanggal" id="tglbeli" required value="<?= date('d/m/Y') ?>" placeholder="">
                </div>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label for="inputEmail3" class="col-sm-3 control-label">No#</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" name="id_purchase" required value="<?= getAutoNumber('purchase', 'id_purchase', 'TB' . date('mdy'), 12) ?>" id="inputEmail3" placeholder="">
                </div>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label for="inputEmail3" class="col-sm-3 control-label">Supplier</label>
                <div class="col-sm-9">
                  <select name="id_supplier" required class="form-control" id="id_supplier">
                    <option value="">--PILIH--</option>
                    <?php foreach ($supplier->result() as $s) : ?>
                      <option value="<?= $s->supplier_id ?>"><?= $s->name ?></option>
                    <?php endforeach ?>
                  </select>
                </div>
              </div>
            </div>
            <div class="col-md-3" style="font-size: 25px;font-weight: bold; padding-right: 30px;padding-left: 80px">
              <?php $total = 0;
              foreach ($this->cart->contents() as $items) {
                if ($items['type'] == 0) {
                  $total += $items['subtotal'];
                }
              } ?>
              Rp. <div class="pull-right"><span id="total"><?= rupiah($total) ?></span></div>
            </div>
          </div>
          <div class="row" style="border-top: 1px solid #eee;padding-top: 5px;margin-bottom: 5px">
            <div class="col-md-4">
              <label for="">Kodebarang</label>
              <div class="input-group input-group-lg">
                <div class="input-group-addon">
                  <i class="glyphicon glyphicon-qrcode"></i>
                </div>
                <input type="text" placeholder="Type Kode Barang" class="form-control pull-right" id="kodebarang">
                <span class="input-group-btn">
                  <button type="button" data-toggle="modal" data-target="#itemModal" class="btn <?= btncolor(getsetting()->theme) ?>"><i class="fa fa-search"></i></button>
                </span>
              </div>
            </div>
            
          </div>
          <div class="row">
          <div id="formtemp" class="col-md-12" style="display: none">
          <!-- <div id="formtemp" class="col-md-12"> -->
              <table width="100%" class="table-condensed">
                <tr>
                  <th>Nama Barang</th>
                  <th width="100px">Harga Pokok</th>
                  <th width="100px">Harga Jual</th>
                  <th width="100px">Harga Jual 3</th>
                  <th width="100px">Harga Jual 5</th>
                  <th width="100px">Harga Jual 10</th>
                  <th width="80px">Qty</th>
                  <th></th>
                </tr>
                <tr>
                  <form action="<?= base_url('kasir/insert_cart') ?>" method="post">
                    <input type="hidden" name="id_barang_tmp" id="id_barang_tmp">
                    <td style="padding: 0 5px 0 0"><input type="text" readonly name="nmbrg_tmp" id="nmbrg_tmp" class="form-control"></td>
                    <td style="padding: 0 5px 0 0"><input type="text" name="harpok_tmp" id="harpok_tmp" class="form-control rupiah"></td>
                    <td style="padding: 0 5px 0 0"><input type="text" name="harjul_tmp" id="harjul_tmp" class="form-control rupiah"></td>
                    <td style="padding: 0 5px 0 0"><input type="text" name="harjul3_tmp" id="harjul3_tmp" class="form-control rupiah"></td>
                    <td style="padding: 0 5px 0 0"><input type="text" name="harjul5_tmp" id="harjul5_tmp" class="form-control rupiah"></td>
                    <td style="padding: 0 5px 0 0"><input type="text" name="harjul10_tmp" id="harjul10_tmp" class="form-control rupiah"></td>
                    <td style="padding: 0 5px 0 0"><input type="number" value="0" name="qty_tmp" id="qty_tmp" class="form-control"></td>
                    <td><button type="button" id="btn_add_to_cart" class="btn btn-sm btn-success"><i class="fa fa-plus"></i></button></td>
                  </form>
                </tr>
              </table>
            </div>            
          </div>
          <table class="table table-striped table-condensed table-bordered">
            <thead>
              <tr>
                <th width="10px">No</th>
                <th>Kode Barang</th>
                <th>Nama Barang</th>
                <th class="text-center">Harga Pokok</th>
                <th class="text-center">Harga Jual</th>
                <th class="text-center">Qty</th>
                <th class="text-center">Sub Total</th>
                <th class="text-center" width="15px">Aksi</th>
              </tr>
            </thead>
            <tbody id="detail_cart">
              <?php
              $no = 0;
              foreach ($this->cart->contents() as $items) {
                if ($items['type'] == 0) {
                  $no++;
                  echo '                  
                      <tr>
                          <td>' . $no . '</td>
                          <td width="100px">' . $items['id'] . '</td>
                          <td width="300px">' . $items['name'] . '</td>
                          <td class="text-right">' . number_format($items['price']) . '</td>
                          <td class="text-right">' . number_format($items['harga_jual']) . '</td>
                          <td class="text-right">' . $items['qty'] . ' PC</td>
                          <td class="text-right">' . number_format($items['subtotal']) . '</td>
                          <td class="text-center" width="70px">
                              <button type="button" id="' . $items['rowid'] . '" class="hapus_cart btn btn-danger btn-xs"><i class="fa fa fa-times"></i></button>
                          </td>
                      </tr>
                      ';
                }
              };
              if ($total == 0) {
                echo '
                <tr>
                  <td colspan="8">Tidak ada data</td>
                </tr>
                ';
              }
              echo '<input type="hidden" id="totalharga" name="totalharga" value="'.rupiah($total).'">';
              ?>
            </tbody>
            <tfoot>
              <tr>
                <td colspan="6"></td>
                <td class="text-right"><button type="submit" class="btn <?= btncolor(getsetting()->theme) ?>"><i class="fa fa-send-o"></i> Simpan</button></td>
                <td></td>
              </tr>
            </tfoot>
        </form>
        </table>
      </div>
      <!-- /.box-body -->
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