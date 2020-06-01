<div id="flashdata" data-type="<?= $this->session->flashdata('type') ?>" data-message="<?= $this->session->flashdata('message') ?>"></div>
<div class="row">
  <div class="col-md-12">
    <div class="box box-default" style="margin-bottom: 10px">
      <div class="box-header with-border">
        <h3 class="box-title"><i class="fa fa-id-card"></i> <?= $sub_title ?></h3>
      </div>
      <div class="box-body">
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="daterange">Pilih Range Tanggal & Jenis</label>
              <form action="<?= base_url('report/stock_in_out') ?>" method="post">
                <div class="input-daterange input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" name="start" value="<?= $startdate ?>" class="form-control datepicker" readonly>
                  <div class="input-group-addon">to</div>
                  <input type="text" name="end" readonly class="form-control datepicker" value="<?= $enddate ?>">
                  <div class="input-group-addon">
                    <i class="fa fa-cubes"></i>
                  </div>
                  <select class="form-control" name="type" id="type">
                    <option value="2" <?= $type==2?'selected':'' ?>>Semua</option>
                    <option value="1" <?= $type==1?'selected':'' ?>>Stok Masuk</option>
                    <option value="0" <?= $type==0?'selected':'' ?>>Stok Keluar</option>
                  </select>

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
        <h3 class="box-title"><i class="fa fa-list-ul"></i> Daftar <?php 
        if($type==2) { echo 'Stok Masuk&Keluar'; }  
        else if($type==1) { echo 'Stok Masuk';}
        else { echo 'Stok Keluar'; }?> </h3>
        <div class="pull-right">
        </div>
      </div>
      <div class="box-body">
        <div class="row">
          <div class="col-md-12 text-center">
            <strong>Laporan 
            <?php 
            if($type==2) { echo 'Stok Masuk&Keluar'; }  
            else if($type==1) { echo 'Stok Masuk';}
            else { echo 'Stok Keluar'; }?>
            </strong>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12 text-center">
            <?php if ($startdate == $enddate) : ?>
              <?= tanggal_indo2($startdate) ?>
            <?php else : ?>
              <?= tanggal_indo2($startdate) ?> - <?= tanggal_indo2($enddate) ?>
            <?php endif ?>
          </div>
        </div>
        <div class="table-responsive">
          <table class="table table-bordered table-striped">
            <thead>
              <tr>
                <th width="10px">No</th>
                <th>Tanggal</th>
                <th>Kode Barang</th>
                <th>Nama Barang</th>
                <th>Qty</th>
                <th>Keterangan</th>
                <th>Jenis</th>
              </tr>
            </thead>
            <tbody>
            <?php if ($stokinout->num_rows() > 0) : ?>
                <?php $no = 1;
                  foreach ($stokinout->result() as $sio) :
                    $datetime = date_create($sio->datetime);
                    ?>
                  <tr>
                    <td><?= $no ?></td>
                    <td><?= date_format($datetime, 'd/m/Y') ?></td>
                    <td><?= $sio->id_product ?></td>
                    <td><?= $sio->name_product ?></td>
                    <td><?= $sio->qty ?></td>
                    <td><?= $sio->detail ?></td>
                    <td><?= $sio->type==1?'Stok Masuk':'Stok Keluar' ?></td>
                  </tr>
                <?php $no++; endforeach ?>
              <?php else : ?>
                <tr>
                  <td colspan="7">Data tidak ada</td>
                </tr>
              <?php endif ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>