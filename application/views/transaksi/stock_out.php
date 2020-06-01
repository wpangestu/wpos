<div id="flashdata" data-type="<?= $this->session->flashdata('type') ?>" data-message="<?= $this->session->flashdata('message') ?>"></div>
<div class="row">
<div class="col-md-12">
  <div class="box box-default">
    <div class="box-header with-border">
      <h3 class="box-title"><i class="fa fa-thumbs-o-up"></i> <?= $sub_title ?></h3>
    </div>
    <div class="box-body">
      <a href="<?= base_url('transaksi/stokout/tambah') ?>" class="btn <?= btncolor(getsetting()->theme) ?>" style="margin-bottom: 7px"><i class="fa fa-plus-square"></i> Tambah</a>
      <table class="table datatables table-bordered table-striped">
        <thead>
          <tr>
            <th width="10px">No</th>
            <th>Kode Barang</th>
            <th>Nama Barang</th>
            <th>Qty</th>
            <th>Tanggal</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php $no = 1;
          foreach ($stockin->result() as $si) : ?>
            <tr>
              <td><?= $no ?></td>
              <td><?= $si->id_product ?></td>
              <td><?= $si->name_product ?></td>
              <td><?= $si->qty ?></td>
              <td><?= $si->datetime ?></td>
              <td>
                <button data-id="<?= $si->id_product ?>" data-name="<?= $si->name_product ?>" data-qty="<?= $si->qty ?>" data-tgl="<?= tanggal_indo($si->datetime) ?>" data-ket="<?= $si->detail ?>" data-target="#modal-detail" data-toggle="modal" class="detail_stock btn bg-navy btn-xs"><i class="fa fa-info-circle"></i> detail</button>
                <button class="btn btn-xs btn-danger"><i class="fa fa-trash"></i> hapus</button>
              </td>
            </tr>
          <?php $no++;
          endforeach ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
</div>

<div class="modal fade" id="modal-detail">
<div class="modal-dialog modal-md">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span></button>
      <h4 class="modal-title">Detail Stok Out</h4>
    </div>
    <div class="modal-body">
      <table class="table table-striped table-bordered">
        <tr>
          <th>Tanggal</th><td id="tgl_si"></td>
        </tr>
        <tr>
          <th>Kode Barang</th><td id="kd_brg_si"></td>
        </tr>
        <tr>
          <th>Nama Barang</th><td id="nm_brg_si"></td>
        </tr>
        <tr>
          <th>Qty</th><td id="qty_si"></td>
        </tr>
        <tr>
          <th>Keterangan</th><td id="ket_si"></td>
        </tr>
      </table>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
    </div>
  </div>
  <!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
</div>
<!-- /.modal -->