<!DOCTYPE html>
<html lang="en">

<head>
  <title><?= $sub_title ?></title>
  <style>
    body {}

    hr {
      border: solid 1px black;
    }

    table.border,
    td.border,
    th.border {
      border: 1px solid black;
      border-collapse: collapse;
      padding: 5px;
    }

    th {
      font-weight: bold;
    }

    .serif {
      font-family: Arial, Helvetica, sans-serif;
    }

    .miring {
      font-style: italic;
    }
  </style>
</head>

<body>
  <img src="<?php echo $_SERVER['DOCUMENT_ROOT'] . "/wpos/assets/img/".getsetting()->logo ?>" style="width: 60px; float: left">
  <table width=100%>
    <tr>
      <th align="center" style="font-size: 25px; font-family: sans-serif"><?= getsetting()->nm_toko ?></th>
    </tr>
    <tr>
      <th align="center" style="font-family: sans-serif;font-size: 15px"><?= getsetting()->keterangan_toko ?></th>
    </tr>
  </table>
  <hr>
  <table width="100%">
    <tr>
      <td align="center">Laporan Penjualan Detail</td>
    </tr>
    <tr>
      <td align="center">
        <?php if ($startdate == $enddate) : ?>
          <?= tanggal_indo2($startdate) ?>
        <?php else : ?>
          <?= tanggal_indo2($startdate) ?> - <?= tanggal_indo2($enddate) ?>
        <?php endif ?>
      </td>
    </tr>
  </table>
  <table class="border" width="100%">
    <tr style="background-color: greenyellow">
      <td class="border">No</td>
      <td class="border">No Trans</td>
      <td class="border">Tanggal</td>
      <td class="border">Jam</td>
      <td class="border">Kode Barang</td>
      <td class="border">Nama Barang</td>
      <td class="border">Harga Pokok</td>
      <td class="border">Harga Jual</td>
      <td class="border">Qty</td>
      <td class="border">Diskon</td>
      <td class="border">Total</td>
      <td class="border">Laba/Rugi</td>
    </tr>
    <?php if ($sale_detail->num_rows() > 0) : ?>
      <?php $tt = 0;
        $tu = 0; ?>
      <?php $no = 1;
        foreach ($sale_detail->result() as $sd) : ?>
        <?php $datetime = date_create($sd->datetime_sales) ?>
        <tr>
          <td class="border"><?= $no ?></td>
          <td class="border"><?= $sd->invoice ?></td>
          <td class="border"><?= date_format($datetime, 'd/m/Y') ?></td>
          <td class="border"><?= date_format($datetime, 'H:s:i') ?></td>
          <td class="border"><?= $sd->kode_product ?></td>
          <td class="border"><?= $sd->name_product ?></td>
          <td class="border" align="right"><?= rupiah($sd->price) ?></td>
          <?php $k = $sd->price * $sd->qty ?>
          <td class="border" align="right"><?= rupiah($sd->price_sale) ?></td>
          <td class="border" align="right"><?= $sd->qty ?></td>
          <td class="border" align="right"><?= rupiah($sd->discount) ?></td>
          <td class="border" align="right"><?= rupiah($sd->sub_total) ?></td>
          <?php $untung = $sd->sub_total - $k ?>
          <td class="border" align="right"><?= rupiah($untung) ?></td>
        </tr>
        <?php $tt += $sd->sub_total;
            $tu += $untung ?>
      <?php $no++;
        endforeach ?>
      <tr>
        <th colspan="10" class="border" align="right">T O T A L :</th>
        <td class="border" align="right"><?= rupiah($tt) ?></td>
        <td class="border" align="right"><?= rupiah($tu) ?></td>
      </tr>
    <?php else : ?>
      <tr>
        <td class="border" colspan="12">Data tidak ada</td>
      </tr>
    <?php endif ?>
  </table>
  <table>
    <tr><td class="miring">Digenerate tanggal</td><td class="miring">: <?= date('d/m/Y H:i:s') ?></td></tr>
    <tr><td class="miring">Digenerate oleh</td><td class="miring">: <?= getuser()->username ?></td></tr>
  </table>
</body>

</html>