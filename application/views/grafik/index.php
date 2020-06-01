<div class="row">
  <div class="col-md-12">
    <div class="box box-default">
      <div class="box-header with-border">
        <i class="fa fa-line-chart"></i>

        <h3 class="box-title">Grafik Penjualan</h3>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
        <div class="row">
          <div class="col-md-3">
            <div class="input-group">
              <div class="input-group-addon">
                <i class="fa fa-calendar"></i>
              </div>
              <input type="text" name="tglrange" value="<?= $startdate ?> - <?= $enddate ?>" id="tglrangepick" class="form-control" readonly>
              <div class="input-group-btn">
                <button type="button" id="btn_grafik_hari" class="btn <?= btncolor(getsetting()->theme) ?>"><i class="fa fa-search"></i></button>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div id="harian" style="min-height: 300px">
              <div id="chartContainer" style="height: 370px; width: 100%;"></div>
            </div>
          </div>
        </div>
        <div class="row" style="margin-top:10px">
          <div class="col-md-12">
            <h4 class="page-header"></h4>
            <div class="form-group">
              <label for="daterange">Range Bulan</label>
              <div class="row">
                <div class="col-md-4">
                  <div class="input-daterange input-group">
                    <div class="input-group-addon">
                      <i class="fa fa-calendar"></i>
                    </div>
                    <input type="text" name="start" id="startmonth" value="<?= $startmonth ?>" class="form-control monthpick" readonly>
                    <div class="input-group-addon">to</div>
                    <input type="text" name="end" id="endmonth" class="form-control monthpick" readonly value="<?= $endmonth ?>">
                    <div class="input-group-btn">
                      <button type="button" id="btn_grafik_bln" class="btn <?= btncolor(getsetting()->theme) ?>"><i class="fa fa-search"></i></button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div id="bulanan" style="min-height: 300px">
              <div id="chartMonth" style="height: 370px; width: 100%;"></div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
          <h4 class="page-header"></h4>
            <div class="form-group">
              <label for="daterange">Range Tahun</label>
              <div class="row">
                <div class="col-md-4">
                  <div class="input-daterange input-group">
                    <div class="input-group-addon">
                      <i class="fa fa-calendar"></i>
                    </div>
                    <input type="text" id="startyear" name="start" value="<?= $startyear ?>" class="form-control yearpick" readonly>
                    <div class="input-group-addon">to</div>
                    <input type="text" id="endyear" name="end" class="form-control yearpick" readonly value="<?= $endyear ?>">
                    <div class="input-group-btn">
                      <button type="button" id="btn_chart_year" class="btn <?= btncolor(getsetting()->theme) ?>"><i class="fa fa-search"></i></button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div id="tahunan" style="min-height: 300px">
              <div id="chartYear" style="height: 370px; width: 100%;"></div>
            </div>
          </div>
        </div>
      </div>
      <!-- /.box-body -->
    </div>
    <!-- /.box -->
  </div>
  <!-- /.col -->
</div>