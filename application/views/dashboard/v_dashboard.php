<?php if (getuser()->level == 'admin') : ?>
  <div class="row">
    <div class="col-lg-3 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-aqua">
        <div class="inner">
          <h3><?= $product->num_rows() ?></h3>

          <p>Data Barang</p>
        </div>
        <div class="icon">
          <i class="fa fa-cubes"></i>
        </div>
        <a href="<?= base_url('product') ?>" class="small-box-footer">Selengkapnya <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-green">
        <div class="inner">
          <h3><sup style="font-size: 20px">Rp </sup><?= rupiah($total_month->total) ?></h3>

          <p>Penjualan Bulan Ini</p>
        </div>
        <div class="icon">
          <i class="fa fa-dollar"></i>
        </div>
        <a href="<?= base_url('report/sell_monthly') ?>" class="small-box-footer">Selengkapnya <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-yellow">
        <div class="inner">
          <h3><?= $transaksi ?></h3>

          <p>Transaksi Bulan Ini</p>
        </div>
        <div class="icon">
          <i class="ion ion-arrow-shrink"></i>
        </div>
        <a href="<?= base_url('report/sell_summary') ?>" class="small-box-footer">Selengkapnya <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-red">
        <div class="inner">
          <h3><?= $jmluser ?></h3>

          <p>Pengguna</p>
        </div>
        <div class="icon">
          <i class="fa fa-users"></i>
        </div>
        <a href="<?= base_url('users') ?>" class="small-box-footer">Selengkapnya <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="box box-solid">
        <div class="box-header with-border">
          <h3 class="box-title">Pintasan</h3>
        </div>
        <div class="box-body">
          <a href="<?= base_url('product') ?>" class="btn btn-app">
            <i class="fa fa-cubes"></i> Barang
          </a>
          <a href="<?= base_url('penjualan') ?>" class="btn btn-app">
            <i class="fa fa-shopping-cart"></i> Penjualan
          </a>
          <a href="<?= base_url('tampil_penjualan') ?>" class="btn btn-app">
            <i class="fa fa-book"></i> Tampil Penjualan
          </a>
          <a href="<?= base_url('grafik') ?>" class="btn btn-app">
            <i class="fa fa-bar-chart"></i> Grafik Penjualan
          </a>
          <a href="<?= base_url('#') ?>" class="btn btn-app">
            <i class="fa fa-file-text"></i> Laporan Penjualan
          </a>
        </div>
      </div>
    </div>
  </div>
  <!-- START ALERTS AND CALLOUTS -->
  <div class="row">
    <div class="col-md-6">
      <div class="box">
        <div class="box-header with-border">
          <i class="fa fa-line-chart"></i>

          <h3 class="box-title">Grafik Penjualan 7 Hari Terakhir</h3>
          <a href="<?= base_url('grafik') ?>" class="btn pull-right btn-xs <?= btncolor(getsetting()->theme) ?>">Selengkapnya <i class="fa fa-arrow-circle-right"></i></a>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <!-- <canvas width="1000" height="300" id="bar-chart"></canvas> -->
          <div id="chartContainer" style="height: 300px; width: 100%;"></div>
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
    </div>
    <!-- /.col -->
    <div class="col-md-6">
      <div class="box box-default">
        <div class="box-header with-border">
          <i class="fa fa-line-chart"></i>

          <h3 class="box-title">5 Barang Terlaris Bulan Ini</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <!-- <canvas width="1000" height="300" id="bar-chart"></canvas> -->
          <div id="chartMostSale" style="height: 300px; width: 100%;"></div>
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
    </div>
    <!-- /.col -->
  </div>
<?php elseif (getuser()->level == 'kasir') : ?>
  <div class="row">
    <div class="col-md-12">
      <div class="alert alert-success alert-dismissible">
        <h4><i class="icon fa fa-check"></i>Login Berhasil</h4>Selamat datang <b><?= getuser()->name ?></b> [username : <strong><?= getuser()->username ?></strong>], <br>Anda login sebagai <?= getuser()->level ?>
      </div>
    </div>
  </div>
<?php endif ?>