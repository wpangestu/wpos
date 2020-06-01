<div id="flashdata" data-type="<?= $this->session->flashdata('type') ?>" data-message="<?= $this->session->flashdata('message') ?>"></div>
<div class="row">
  <div class="col-md-12">
    <div class="box box-default" style="margin-bottom: 10px">
      <div class="box-header with-border">
      <a href="<?= base_url('report/sell_bycustomer/') ?>" class="fa fa-arrow-left"></a>
        <h3 class="box-title"><i class="fa fa-id-card"></i> <?= $sub_title ?></h3>
        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
          </button>
        </div>
      </div>
      <div class="box-body">
        <div class="row">
          <div class="col-md-6">
            <table class="table table-striped">
              <tr>
                <th width="30%">No Pelanggan</th>
                <td width="70%">: <?= $pelanggan->id_customer ?></td>
              </tr>
              <tr>
                <th>Nama</th>
                <td>: <?= $pelanggan->name_customer ?></td>
              </tr>
              <tr>
                <th width="20px">Alamat</th>
                <td>: <?= ($pelanggan->address!="")?$pelanggan->address:'-'  ?></td>
              </tr>
            </table>
          </div>
          <div class="col-md-6">
            <table class="table table-striped">
            <tr>
                <th width="30%">Belanja hari ini</th>
                <td width="70%">: Rp. <?= $sale_today!=null? rupiah($sale_today->total):'0' ?></td>
              </tr>
            <tr>
                <th width="30%">Belanja bulan ini</th>
                <td width="70%">: Rp. <?= $sale_thismonth!=null? rupiah($sale_thismonth->total):'0' ?></td>
              </tr>
              <tr>
                <th>Terakhir Belanja</th>
                <?php if($last_sale!=null): ?>
                  <?php $datetime = date_create($last_sale->datetime_sales) ?>
                  <td>: <?= tanggal_indo2(date_format($datetime,'d/m/Y')) ?> - <?= date_format($datetime,'H.i') ?></td>
                <?php else: ?>
                  <td>: - </td>
                <?php endif ?>
              </tr>  
            <!-- <tr>
                <th>Total Belanja</th>
                <td>: Rp 780.000</td>
              </tr>
              <tr>
                <th>Belanja Hari ini</th>
                <td>: Lorem ipsum dolor sit amet consectetur adipisicing.</td>
              </tr>
              <tr>
                <th>Belanja Bulan ini</th>
                <td>: -</td>
              </tr>
              <tr>
                <th>Terakhir belanja</th>
                <td>: 05/02/2020 15.00</td>
              </tr> -->
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="row" style="margin-top: -10px">
  <div class="col-md-12">
    <div class="nav-tabs-custom">
      <ul class="nav nav-tabs">
        <li class="active"><a href="#tab_1" data-toggle="tab">Penjualan Detail</a></li>
        <li><a href="#tab_2" data-toggle="tab">Laporan Harian</a></li>
        <li><a href="#tab_3" data-toggle="tab">Laporan Bulanan</a></li>
        <li><a href="#tab_4" data-toggle="tab">Laporan Tahunan</a></li>
      </ul>
      <div class="tab-content">
        <div class="tab-pane active" id="tab_1">
          <div class="row">
            <div class="col-md-4">
              <form action="#" id="penjualan_detail" method="post">
                <input type="hidden" name="id_customer" value="<?= $kode ?>">
                <div class="form-group">
                  <label>Range Tanggal:</label>
                  <div class="input-group input-daterange">
                    <div class="input-group-addon">
                      <i class="fa fa-calendar"></i>
                    </div>
                    <input type="text" name="startdate" id="start" class="form-control datepicker" readonly value="<?= date('d/m/Y') ?>">
                    <div class="input-group-addon"> - </div>
                    <input type="text" name="enddate" id="end" class="form-control datepicker" readonly value="<?= date('d/m/Y') ?>">
                    <span class="input-group-btn">
                      <button type="submit" id="btn-penjualan-detail"class="btn <?= btncolor(getsetting()->theme) ?> btn-flat">Tampil</button>
                    </span>
                  </div>
                </div>
              </form>
            </div>
          </div>

          <div class="row">
            <div class="col-lg-6">
              <div id="result-tab-1">

              </div>
            </div>
            <div class="col-lg-6" id="result_struk">
              
            </div>
          </div>
        </div>
        <!-- /.tab-pane -->
        <div class="tab-pane" id="tab_2">
          <div class="row">
            <div class="col-md-4">
              <form action="#" id="penjualan_harian" method="post">
                <input type="hidden" name="id_customer" value="<?= $kode ?>">
                <div class="form-group">
                  <label>Range Tanggal:</label>
                  <div class="input-group input-daterange">
                    <div class="input-group-addon">
                      <i class="fa fa-calendar"></i>
                    </div>
                    <input type="text" name="startdate" class="form-control datepicker" value="<?= date('01/m/Y') ?>" readonly>
                    <div class="input-group-addon"> - </div>
                    <input type="text" name="enddate" class="form-control datepicker" value="<?= date('t/m/Y') ?>" readonly>
                    <span class="input-group-btn">
                      <button type="submit" id="btn-penjualan-harian" class="btn <?= btncolor(getsetting()->theme) ?> btn-flat">Tampil</button>
                    </span>
                  </div>
                </div>
              </form>
            </div>
          </div>

          <div class="row">
            <div class="col-lg-12">
              <div id="result_tab_2">
                
              </div>
            </div>
          </div>
        </div>
        <!-- /.tab-pane -->
        <div class="tab-pane" id="tab_3">
          <div class="row">
            <div class="col-lg-12">
              <div class="form-group">
                <label for="daterange">Range Bulan</label>
                <div class="row">
                  <div class="col-md-4">
                    <form id="penjualan_bulanan" action="<?= base_url('report/sell_monthly') ?>" method="post">
                      <input type="hidden" name="id_customer" value="<?= $kode ?>">
                      <div class="input-group input-daterange">
                        <div class="input-group-addon">
                          <i class="fa fa-calendar"></i>
                        </div>
                        <input type="text" name="start" value="<?= "Jan ".date('Y') ?>" class="form-control monthpicker2" readonly>
                        <div class="input-group-addon">to</div>
                        <input type="text" name="end" class="form-control monthpicker2" value="<?= "Des ".date('Y') ?>" readonly>
                        <div class="input-group-btn">
                          <button id="btn-penjualan-bulan" type="submit" class="btn <?= btncolor(getsetting()->theme) ?> btn-flat">Tampil</button>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-lg-12">
              <div id="result_tab_3">

              </div>
            </div>
          </div>
        </div>

        <div class="tab-pane" id="tab_4">
          <div class="row">
              <div class="col-md-4">
                <form action="#" id="penjualan_tahunan" method="post">
                  <input type="hidden" name="id_customer" value="<?= $kode ?>">
                  <div class="form-group">
                    <label>Range Tahun:</label>
                    <div class="input-group input-daterange">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <input type="text" readonly name="startyear" class="form-control yearpick" value="<?= date('Y') ?>">
                      <div class="input-group-addon"> - </div>
                      <input type="text" readonly name="endyear" class="form-control yearpick" value="<?= date('Y') ?>">
                      <span class="input-group-btn">
                        <button type="submit" id="btn-penjualan-tahun" class="btn <?= btncolor(getsetting()->theme) ?> btn-flat">Tampil</button>
                      </span>
                    </div>
                  </div>
                </form>
              </div>
            </div>

            <div class="row">
              <div class="col-lg-12">
                <div id="result-tab-4">

                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /.tab-pane -->
      </div>
      <!-- /.tab-content -->
    <!-- </div> -->
    <!-- nav-tabs-custom -->
  </div>
  <!-- <div class="col-md-6">
    <div class="box box-solid">
      <div class="box-header text-center with-border">
        <h3 class="box-title">Struk Transaksi</h3>
      </div>
      <div class="box-body">             
        <div id="result_struk">
        
        </div>
      </div>  
    </div>
  </div> -->
</div>