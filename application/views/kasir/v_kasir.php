<div id="flashdata" data-type="<?= $this->session->flashdata('type') ?>" data-message="<?= $this->session->flashdata('message') ?>"></div>
<div class="row">
  <div class="col-md-8">
    <div class="box box-red">
      <div class="box-header with-border">
        <i class="fa fa-shopping-cart"></i>

        <h3 class="box-title"><?= $sub_title ?></h3>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
        <!-- BATAS TEMPLATE -->
        <div class="row">
          <div class="col-md-12">
            <div class="row">
              <div class="col-md-12">
                <label for="">Kodebarang</label>
                <div class="input-group input-group-lg">
                  <div class="input-group-addon">
                    <i class="glyphicon glyphicon-qrcode"></i>
                  </div>
                  <input type="text" autofocus autocomplete="off" placeholder="Scan Kode Barang / Pilih barang dengan klik icon cari" class="form-control pull-right" id="kodebarang">
                  <span class="input-group-btn">
                    <button id="btn_show_modal_add_produk" type="button" title="Tambah barang" class="btn <?= btncolor(getsetting()->theme) ?>"><i class="fa fa-plus"></i></button>
                  </span>
                </div>
              </div>
            </div>
           
            <div class="row" style="margin-top: 10px">
              <div class="col-md-12 table-responsive">
                <table id="tbl_cart" class="table table-striped table-bordered">
                  <thead>
                    <tr class="text-center">
                      <th>#</th>
                      <th>Kode Item</th>
                      <th>Nama Item</th>
                      <th class="text-center">Harga</th>
                      <th class="text-center">Diskon</th>
                      <th class="text-center">Qty</th>
                      <th class="text-center">Subtotal</th>
                      <th class="text-center">Aksi</th>
                    </tr>
                  </thead> 
                  <tbody id="detail_cart">
                    <?php $i = 1; ?>
                    <?php $total = 0; ?>
                    <?php $cek = false ?>
                    <?php if ($this->cart->contents() > 0) : ?>
                      <?php foreach ($this->cart->contents(TRUE) as $items) : ?>
                        <?php if ($items['type'] == 1) : ?>
                          <?php $cek=true; ?>
                          <?php $total += $items['subtotal'] ?>
                          <tr>
                                <td>
                                  <input type="checkbox" name="custom" class="cb_cart" data-id="<?= $items['rowid'] ?>" <?= $items['custom']=="on"?"checked":"" ?>>   
                                </td>
                                <td><?= $items['id'] ?></td>
                                <td><span class="name_product" data-kode="<?= $items['id'] ?>"><?= $items['name'] ?></span></td>
                                <td class="text-right">
                                  <input name="price_sale" <?= $items['custom']=="on"?"":"readonly" ?> data-id="<?= $items['rowid'] ?>" id="inputjual-<?= $items['rowid'] ?>" onclick="this.select()" class="text-right rupiah input-price_sale" style="width:100px" type="text" value="<?= $items['harga_jual'] ?>" />
                                </td>
                                <td class="text-right">
                                  <input name="discount" data-id="<?= $items['rowid'] ?>" id="inputdiscount-<?= $items['rowid'] ?>" onclick="this.select()" class="text-right rupiah input-discount" style="width:70px" type="text" value="<?= $items['disc'] ?>" />
                                </td>
                                <td>
                                <form action="#" class="form_cart" id="form_cart-<?= $items['rowid'] ?>" method="post">
                                    <input name="qty" id="inputqty-<?= $items['rowid'] ?>" onclick="this.select()" data-rowid="<?= $items['rowid'] ?>" type="number" value="<?= $items['qty'] ?>" min="0" class="text-center" style="width:50px">
                                    <input type="hidden" value="<?= $items['rowid'] ?>" name="rowid">
                                    <input type="hidden" value="<?= $items['custom']=="on"?"on":"off" ?>" name="custom" id="custom-<?= $items['rowid'] ?>">
                                    <input type="hidden" value="<?= $items['harga_jual'] ?>" id="price_sale-<?= $items['rowid'] ?>" name="price_sale">
                                    <input type="hidden" value="<?= $items['disc'] ?>" id="disc-<?= $items['rowid'] ?>" name="diskon">
                                </form>
                                </td>
                                <td class="text-right"><?= number_format($items['subtotal']) ?></td>
                                <td class="text-center">
                                  <div class="btn-group">
                                    <button data-rowid="<?= $items['rowid'] ?>" data-id="<?= $items['id'] ?>" type="button" id="<?= $items['rowid'] ?>" class="editproduk btn btn-primary btn-xs"><i class="fa fa-edit"></i></button>
                                    <button type="button" data-id="<?= $items['rowid'] ?>" class="hapus_cart btn btn-danger btn-xs"><i class="fa fa fa-times"></i></button>
                                  </div>
                                </td>
                          </tr>
                          <?php $i++; ?>
                        <?php endif ?>
                      <?php endforeach; ?>
                    <?php endif ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
        <!-- Batas Template -->
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <form class="form-horizontal" method="post" action="<?= base_url('kasir/proses_penjualan') ?>">
      <div class="row">
        <div class="col-md-12">
          <div class="box box-default">
            <div class="box-header with-border">
              <i class="fa fa-desktop"></i>

              <h3 class="box-title">Info Transaksi</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="form-group">
                <label for="customer" class="col-sm-4 control-label">Pelenggan</label>
                <div class="col-sm-8">
                  <select name="customer" id="selectcustomer" class="form-control select2">
                    <option value="1">Umum</option>
                    <?php foreach ($customers as $c) : ?>
                      <option value="<?= $c->id_customer ?>"><?= $c->name_customer ?></option>
                    <?php endforeach ?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label for="tanggal" class="col-sm-4 control-label">Tanggal</label>
                <div class="col-sm-8">
                  <input type="text" readonly class="form-control" name="tanggal" value="<?= date('d/m/Y') ?>" placeholder="Email">
                </div>
              </div>
              <div class="form-group">
                <label for="invoice" class="col-sm-4 control-label">No Trans#</label>
                <div class="col-sm-8">
                  <input type="text" readonly class="form-control" name="invoice" placeholder="Email" value="<?= getAutoNumber('sales', 'invoice', date('m.y.'), 10) ?>">
                </div>
              </div>
              <div class="form-group">
                <label for="user" class="col-sm-4 control-label">Kasir</label>
                <div class="col-sm-8">
                  <input type="text" readonly class="form-control" name="user" placeholder="Email" value="<?= strtoupper(getuser()->username) ?>">
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="box box-solid">
            <div class="box-header with-border">
              <!-- <i class="fa fa-money"></i> -->
              <h3 class="box-title">Total Harga (Rp)</h3>
            </div>
            <div class="box-body">
              <div class="row">
                <div class="col-md-12" style="font-size: 50px">
                  <div class="pull-right"><span id="hargatotalbesar"><?= rupiah($total) ?></span></div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <table width="100%">
                    <tr>
                      <td style="padding: 5px"><button type="button" id="btn_modal_proses" class="btn btn-lg btn-block btn-success"><i class="fa fa-money"></i> Proses Bayar</button></td>
                      <td style="padding: 5px"><a href="<?= base_url('kasir/reset') ?>" onclick="return confirm('Apa anda yakin?')" class="btn btn-lg btn-block btn-danger">Reset</a></td>
                    </tr>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal fade" id="prosesmodal" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h3 class="modal-title" id="myModalLabel">Proses Pembayaran</h3>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-md-12">
                  <div class="box box-solid" style="margin-top:-5px">
                    <div class="box-body">
                      <!-- <div class="form-group">
                        <label for="inputEmail3" class="col-sm-4 control-label">Pelanggan</label>
                        <div class="col-sm-8">
                          <div class="input-group input-group-lg">
                            <div class="input-group-addon">Rp</div>
                            <select class="form-control select2">
                              <option value="">aaa</option>
                              <option value="">bbb</option>
                              <option value="">ccc</option>
                              <option value="">ddd</option>
                              <option value="">fff</option>
                            </select>
                          </div>
                        </div>
                      </div> -->
                      <div class="form-group">
                        <label for="inputEmail3" class="col-sm-4 control-label">Total Harga</label>
                        <div class="col-sm-8">
                          <div class="input-group input-group-lg">
                            <div class="input-group-addon">Rp</div>
                            <input type="text" name="totalharga" readonly value="<?= rupiah($total) ?>" class="form-control" id="pembayaran_total">
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="inputEmail3" class="col-sm-4 control-label">Uang Bayar</label>
                        <div class="col-sm-8">
                          <div class="input-group input-group-lg">
                            <div class="input-group-addon">Rp</div>
                            <input type="text" name="uangbayar" onclick="this.select()" autocomplete="off" class="form-control" id="pembayaran_uang_bayar" placeholder="0">
                          </div>
                        </div>
                      </div>
                      <div class="form-group" id="form_kembali">
                        <label for="inputEmail3" class="col-sm-4 control-label">Uang Kembali </label>
                        <div class="col-sm-8">
                          <div class="input-group input-group-lg">
                            <div class="input-group-addon">Rp</div>
                            <input type="text" readonly class="form-control" id="pembayaran_uang_kembali" name="uangkembali">
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="col-md-4"></div>
                        <div class="col-md-8">
                          <button disabled type=submit name="print_save" class="btn btn-success" id="btn-print-save"><i class="fa fa-print"></i> Simpan & Cetak</button>
                          <button disabled type="submit" name="just_save" class="btn btn-info" id="btn-just-save"><i class="fa fa-save"></i> Simpan saja</button>
                          <button class="btn" type="button" id="btn_close_modal_proses_bayar">Tutup</button>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
    </form>
  </div>
</div>

<!-- Modal Item -->
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
<!-- EndModal -->


<!-- MODAL EDIT CART -->
<div class="modal fade" id="editcart" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title" id="myModalLabel">Edit Cart</h3>
      </div>
      <div class="modal-body table-responsive">
        <form action="#" class="form-horizontal">
          <input type="hidden" name="rowid" id="rowid">
          <div class="form-group">
            <label class="col-sm-3 text-right" for="idbarang">Kode Barang</label>
            <div class="col-md-9">
              <div class="input-group">
                <div class="input-group-addon"><i class="fa fa-qrcode"></i></div>
                <input type="text" readonly class="form-control" id="idbarang" name="idbarang">
              </div>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 text-right" for="nmbarang">Nama Barang</label>
            <div class="col-md-9">
              <input type="text" id="nmbarang" name="nmbarang" readonly class="form-control">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 text-right" for="hrgpokok">Harga Pokok</label>
            <div class="col-md-9">
              <div class="input-group">
                <div class="input-group-addon">Rp</div>
                <input readonly type="text" id="hrgpokok" name="hrgpokok" class="form-control rupiahjs">
              </div>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 text-right" for="hrgjual">Harga Jual</label>
            <div class="col-md-9">
              <div class="input-group">
                <div class="input-group-addon">Rp</div>
                <input type="text" id="hrgjual" onclick="this.select()" name="hrgjual" class="form-control rupiahjs">
              </div>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 text-right" for="qty">Qty</label>
            <div class="col-md-6">
              <div class="input-group">
                <div class="input-group-addon"><i class="fa fa-hand-paper-o fa-rotate-90"></i></div>
                <input type="number" id="qtycart" onclick="this.select()" name="qty" min="1" class="form-control">
              </div>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 text-right" for="disc">Diskon</label>
            <div class="col-md-9">
              <div class="input-group">
                <div class="input-group-addon">Rp</i></div>
                <input type="text" onclick="this.select()" name="disc" id="disc" class="form-control">
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button class="btn btn-success" id="btn_proses_ubah_cart" type="button">Simpan</button>
        <button class="btn" id="btn_close_edit_cart" data-dismiss="modal" aria-hidden="true">Tutup</button>
      </div>
    </div>
  </div>
</div>
<!-- EndModal -->

<!-- Modal Edit Harga Produk -->
<div class="modal fade" id="editproduk" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title" id="myModalLabel">Edit Harga Barang</h3>
      </div>
      <div class="modal-body">
      <form action="<?= base_url('kasir/updateharga') ?>" id="form_edit_produk" method="POST" class="form-horizontal">
          <input type="hidden" name="rowid">
          <div class="form-group">
            <label class="col-sm-3 text-right" for="idbarang">Kode Barang</label>
            <div class="col-md-9">
              <div class="input-group">
                <div class="input-group-addon"><i class="fa fa-qrcode"></i></div>
                <input type="text" readonly class="form-control" name="idbarang">
              </div>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 text-right" for="nmbarang">Nama Barang</label>
            <div class="col-md-9">
              <input type="text" name="nmbarang" class="form-control">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 text-right" for="hrgpokok">Harga Pokok</label>
            <div class="col-md-9">
              <div class="input-group">
                <div class="input-group-addon">Rp</div>
                <input type="text" onclick="this.select()" name="hrgpokok" class="form-control rupiahjs">
              </div>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 text-right" for="hrgjual">Harga Jual</label>
            <div class="col-md-9">
              <div class="input-group">
                <div class="input-group-addon">Rp</div>
                <input type="text" onclick="this.select()" name="hrgjual" class="form-control rupiahjs">
              </div>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 text-right" for="hrgjual3">Harga Jual min. 3</label>
            <div class="col-md-9">
              <div class="input-group">
                <div class="input-group-addon">Rp</div>
                <input type="text" onclick="this.select()" name="hrgjual3" class="form-control rupiahjs">
              </div>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 text-right" for="hrgjual5">Harga Jual min. 5</label>
            <div class="col-md-9">
              <div class="input-group">
                <div class="input-group-addon">Rp</div>
                <input type="text" onclick="this.select()" name="hrgjual5" class="form-control rupiahjs">
              </div>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 text-right" for="hrgjual10">Harga Jual min. 10</label>
            <div class="col-md-9">
              <div class="input-group">
                <div class="input-group-addon">Rp</div>
                <input type="text" onclick="this.select()" name="hrgjual10" class="form-control rupiahjs">
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" id="btn_proses_ubah_produk" class="btn <?= btncolor(getsetting()->theme) ?>">Simpan</button>
          <button class="btn" type="button" id="btn_close_modal_edit_product">Tutup</button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- End Modal -->

<!-- Modal Tambah Produk -->
<div class="modal fade" id="addproduk" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title" id="myModalLabel">Tambah Data Barang</h3>
      </div>
      <div class="modal-body">
      <form action="<?= base_url('kasir/insert_produk') ?>" id="form_add_produk" method="POST" class="form-horizontal">
          <div class="form-group">
            <label class="col-sm-3 text-right" for="idbarang">Kode Barang</label>
            <div class="col-md-9">
              <div class="input-group">
                <div class="input-group-addon"><i class="fa fa-qrcode"></i></div>
                <input type="text" class="form-control" required id="addproduk_idbarang" name="idbarang">
                <span class="input-group-btn">
                    <button type="button" id="btn_generate_kb" class="btn <?= btncolor(getsetting()->theme) ?> btn-flat"><i class="fa fa-retweet"></i></button>
                </span>
              </div>
              <span id="message_exist" class="text-red"></span>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 text-right" for="nmbarang">Nama Barang</label>
            <div class="col-md-9">
              <input type="text" autocomplete="off" required name="nmbarang" class="form-control">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 text-right" for="nmbarang">Stok</label>
            <div class="col-md-9">
              <input type="text" required name="stok" value="100" class="form-control">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 text-right" for="nmbarang">Kategori</label>
            <div class="col-md-9">
              <select name="category_id" required class="form-control">
                  <option value="">pilih</option>
                  <?php foreach ($kategori->result() as $key => $value) : ?>
                    <option value="<?= $value->id ?>"><?= $value->name ?></option>
                  <?php endforeach ?>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 text-right" for="hrgpokok">Harga Pokok</label>
            <div class="col-md-9">
              <div class="input-group">
                <div class="input-group-addon">Rp</div>
                <input type="text" value="0" min="0" onclick="this.select()" name="hrgpokok" class="form-control rupiah">
              </div>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 text-right" for="hrgjual">Harga Jual</label>
            <div class="col-md-9">
              <div class="input-group">
                <div class="input-group-addon">Rp</div>
                <input type="text" min="0" onclick="this.select()" value="0" name="hrgjual" class="form-control rupiah">
              </div>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 text-right" for="hrgjual3">Harga Jual min. 3</label>
            <div class="col-md-9">
              <div class="input-group">
                <div class="input-group-addon">Rp</div>
                <input type="text" onclick="this.select()" value="0" name="hrgjual3" class="form-control rupiah">
              </div>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 text-right" for="hrgjual5">Harga Jual min. 5</label>
            <div class="col-md-9">
              <div class="input-group">
                <div class="input-group-addon">Rp</div>
                <input type="text" onclick="this.select()" value="0" name="hrgjual5" class="form-control rupiah">
              </div>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 text-right" for="hrgjual10">Harga Jual min. 10</label>
            <div class="col-md-9">
              <div class="input-group">
                <div class="input-group-addon">Rp</div>
                <input type="text" onclick="this.select()" value="0" name="hrgjual10" class="form-control rupiah">
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" id="btn_proses_add_produk" class="btn <?= btncolor(getsetting()->theme) ?>">Simpan</button>
          <button class="btn" type="button" id="btn_close_modal_add_product">Tutup</button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- End Modal -->