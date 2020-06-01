<div class="row">
  <div class="col-md-12">
    <div class="box box-default" style="margin-bottom: 10px">
      <div class="box-header with-border">
        <h3 class="box-title"><?= $sub_title ?></h3>
      </div>
      <div class="box-body">
        <div class="row">
          <div class="col-md-6">
            <table class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th width="10px">No</th>
                  <th>Type</th>
                  <th class="text-center">Pilih</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>1</td>
                  <td>Laporan Penjualan Detail</td>
                  <td class="text-center"><a class="btn btn-primary btn-xs" href="<?= base_url('report/sell_detail') ?>">Pilih</a></td>
                </tr>
                <tr>
                  <td>2</td>
                  <td>Laporan Penjualan Ringkasan</td>
                  <td class="text-center"><a class="btn btn-primary btn-xs" href="<?= base_url('report/sell_summary') ?>">Pilih</a></td>
                </tr>
                <tr>
                  <td>3</td>
                  <td>Laporan Penjualan Pelanggan</td>
                  <td class="text-center"><a class="btn btn-primary btn-xs" href="<?= base_url('report/sell_bycustomer') ?>">Pilih</a></td>
                </tr>
                <tr>
                  <td>4</td>
                  <td>Laporan Penjualan Harian</td>
                  <td class="text-center"><a class="btn btn-primary btn-xs" href="<?= base_url('report/sell_daily') ?>">Pilih</a></td>
                </tr>
                <tr>
                  <td>5</td>
                  <td>Laporan Penjualan Bulanan</td>
                  <td class="text-center"><a class="btn btn-primary btn-xs" href="<?= base_url('report/sell_monthly') ?>">Pilih</a></td>
                </tr>
                <tr>
                  <td>6</td>
                  <td>Laporan Penjualan Tahunan</td>
                  <td class="text-center"><a class="btn btn-primary btn-xs" href="<?= base_url('report/sale_yearly') ?>">Pilih</a></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>