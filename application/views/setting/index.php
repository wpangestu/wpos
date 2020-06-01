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
            <form action="<?= base_url('setting/ubah_setting') ?>" method="post" enctype="multipart/form-data">
              <div class="form-group">
                <label for="nama">Nama Toko</label>
                <input type="text" name="nm_toko" value="<?= $setting->nm_toko ?>" required class="form-control" id="nmtoko">
              </div>
              <div class="form-group">
                <label for="nama">Keterangan Toko</label>
                <!-- <input type="text" name="keterangan" id="ketarangan" value="<?= $setting->keterangan_toko ?>" required class="form-control" id="nmtoko"> -->
                <textarea name="keterangan" id="ketarangan" class="form-control text-center" requireds cols="30" rows="3"><?= $setting->keterangan_toko ?></textarea>
              </div>
              <div class="form-group">
                <label for="nama">Logo Toko</label>
                <input type="file" name="image" class="dropify form-control" data-height="100px" data-default-file="<?= base_url('assets/img/' . $setting->logo) ?>">
              </div>
              <div class="form-group">
                <label for="nama">Nama Printer</label>
                <input type="text" name="printer_name" value="<?= $setting->printer_name ?>" required class="form-control" id="printer_name">
              </div>
              <div class="form-group">
                <label for="nama">Footer Struk</label>
                <textarea name="footer_struk" id="footer_struk" class="form-control text-center" requireds cols="30" rows="3"><?= $setting->footer_struk ?></textarea>
              </div>
              <div class="form-group">
                <button type="submit" class="btn <?= btncolor(getsetting()->theme) ?>"><i class="fa fa-send-o"></i> Simpan</button>
              </div>
            </form>
          </div>
          <div class="col-md-3">
            <label for="">Pilih Tema</label>
            <ul class="list-unstyled clearfix">
              <li style="float:left; width: 33.33333%; padding: 5px;">
                <a href="<?= base_url('setting/theme/skin-blue') ?>" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">
                  <div>
                    <span style="display:block; width: 20%; float: left; height: 7px; background: #367fa9"></span>
                    <span class="bg-light-blue" style="display:block; width: 80%; float: left; height: 7px;"></span>
                  </div>
                  <div>
                    <span style="display:block; width: 20%; float: left; height: 20px; background: #222d32"></span>
                    <span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7"></span>
                  </div>
                </a>
                <p class="text-center no-margin">Blue</p>
              </li>
              <li style="float:left; width: 33.33333%; padding: 5px;">
                <a href="<?= base_url('setting/theme/skin-black') ?>" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">
                  <div style="box-shadow: 0 0 2px rgba(0,0,0,0.1)" class="clearfix">
                    <span style="display:block; width: 20%; float: left; height: 7px; background: #fefefe"></span>
                    <span style="display:block; width: 80%; float: left; height: 7px; background: #fefefe"></span>
                  </div>
                  <div>
                    <span style="display:block; width: 20%; float: left; height: 20px; background: #222"></span>
                    <span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7"></span>
                  </div>
                </a>
                <p class="text-center no-margin">Black</p>
              </li>
              <li style="float:left; width: 33.33333%; padding: 5px;">
                <a href="<?= base_url('setting/theme/skin-purple') ?>" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">
                  <div><span style="display:block; width: 20%; float: left; height: 7px;" class="bg-purple-active"></span><span class="bg-purple" style="display:block; width: 80%; float: left; height: 7px;"></span></div>
                  <div><span style="display:block; width: 20%; float: left; height: 20px; background: #222d32"></span><span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7"></span></div>
                </a>
                <p class="text-center no-margin">Purple</p>
              </li>
              <li style="float:left; width: 33.33333%; padding: 5px;">
                <a href="<?= base_url('setting/theme/skin-green') ?>" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">
                  <div><span style="display:block; width: 20%; float: left; height: 7px;" class="bg-green-active"></span><span class="bg-green" style="display:block; width: 80%; float: left; height: 7px;"></span></div>
                  <div><span style="display:block; width: 20%; float: left; height: 20px; background: #222d32"></span><span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7"></span></div>
                </a>
                <p class="text-center no-margin">Green</p>
              </li>
              <li style="float:left; width: 33.33333%; padding: 5px;">
                <a href="<?= base_url('setting/theme/skin-red') ?>" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">
                  <div><span style="display:block; width: 20%; float: left; height: 7px;" class="bg-red-active"></span><span class="bg-red" style="display:block; width: 80%; float: left; height: 7px;"></span></div>
                  <div><span style="display:block; width: 20%; float: left; height: 20px; background: #222d32"></span><span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7"></span></div>
                </a>
                <p class="text-center no-margin">Red</p>
              </li>
              <li style="float:left; width: 33.33333%; padding: 5px;">
                <a href="<?= base_url('setting/theme/skin-yellow') ?>" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">
                  <div><span style="display:block; width: 20%; float: left; height: 7px;" class="bg-yellow-active"></span><span class="bg-yellow" style="display:block; width: 80%; float: left; height: 7px;"></span></div>
                  <div><span style="display:block; width: 20%; float: left; height: 20px; background: #222d32"></span><span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7"></span></div>
                </a>
                <p class="text-center no-margin">Yellow</p>
              </li>
              <li style="float:left; width: 33.33333%; padding: 5px;">
                <a href="<?= base_url('setting/theme/skin-blue-light') ?>" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">
                  <div><span style="display:block; width: 20%; float: left; height: 7px; background: #367fa9"></span><span class="bg-light-blue" style="display:block; width: 80%; float: left; height: 7px;"></span></div>
                  <div><span style="display:block; width: 20%; float: left; height: 20px; background: #f9fafc"></span><span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7"></span></div>
                </a>
                <p class="text-center no-margin" style="font-size: 12px">Blue Light</p>
              </li>
              <li style="float:left; width: 33.33333%; padding: 5px;">
                <a href="<?= base_url('setting/theme/skin-black-light') ?>" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">
                  <div style="box-shadow: 0 0 2px rgba(0,0,0,0.1)" class="clearfix"><span style="display:block; width: 20%; float: left; height: 7px; background: #fefefe"></span><span style="display:block; width: 80%; float: left; height: 7px; background: #fefefe"></span></div>
                  <div><span style="display:block; width: 20%; float: left; height: 20px; background: #f9fafc"></span><span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7"></span></div>
                </a>
                <p class="text-center no-margin" style="font-size: 12px">Black Light</p>
              </li>
              <li style="float:left; width: 33.33333%; padding: 5px;">
                <a href="<?= base_url('setting/theme/skin-purple-light') ?>" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">
                  <div><span style="display:block; width: 20%; float: left; height: 7px;" class="bg-purple-active"></span><span class="bg-purple" style="display:block; width: 80%; float: left; height: 7px;"></span></div>
                  <div><span style="display:block; width: 20%; float: left; height: 20px; background: #f9fafc"></span><span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7"></span></div>
                </a>
                <p class="text-center no-margin" style="font-size: 12px">Purple Light</p>
              </li>
              <li style="float:left; width: 33.33333%; padding: 5px;">
                <a href="<?= base_url('setting/theme/skin-green-light') ?>" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">
                  <div><span style="display:block; width: 20%; float: left; height: 7px;" class="bg-green-active"></span><span class="bg-green" style="display:block; width: 80%; float: left; height: 7px;"></span></div>
                  <div><span style="display:block; width: 20%; float: left; height: 20px; background: #f9fafc"></span><span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7"></span></div>
                </a>
                <p class="text-center no-margin" style="font-size: 12px">Green Light</p>
              </li>
              <li style="float:left; width: 33.33333%; padding: 5px;">
                <a href="<?= base_url('setting/theme/skin-red-light') ?>" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">
                  <div><span style="display:block; width: 20%; float: left; height: 7px;" class="bg-red-active"></span><span class="bg-red" style="display:block; width: 80%; float: left; height: 7px;"></span></div>
                  <div><span style="display:block; width: 20%; float: left; height: 20px; background: #f9fafc"></span><span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7"></span></div>
                </a>
                <p class="text-center no-margin" style="font-size: 12px">Red Light</p>
              </li>
              <li style="float:left; width: 33.33333%; padding: 5px;">
                <a href="<?= base_url('setting/theme/skin-yellow-light') ?>" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">
                  <div><span style="display:block; width: 20%; float: left; height: 7px;" class="bg-yellow-active"></span><span class="bg-yellow" style="display:block; width: 80%; float: left; height: 7px;"></span></div>
                  <div><span style="display:block; width: 20%; float: left; height: 20px; background: #f9fafc"></span><span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7"></span></div>
                </a>
                <p class="text-center no-margin" style="font-size: 12px">Yellow Light</p>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>