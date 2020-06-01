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

    th.borderwhite {
      border: 1px solid white;
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
      <th class="borderwhite" align="center" style="font-family: sans-serif;font-size: 15px"><?= getsetting()->keterangan_toko ?></th>
    </tr>
  </table>
  <hr>
  <table width="100%">
    <tr>
      <td align="center">Laporan Penjualan Ringkasan</td>
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
      <td class="border">Kasir</td>
      <td class="border">Pelanggan</td>
      <td class="border">Total Transaksi</td>
      <td class="border">Laba/Rugi</td>
    </tr>
    <?php if ($sale_summary->num_rows() > 0) : ?>
      <?php $no = 1;$total=0;$lr=0;?>
      <?php
        foreach ($sale_summary->result() as $ss) : ?>
        <?php
        $total +=$ss->total;
        $lr += $ss->untung; 
        $datetime = date_create($ss->datetime_sales) ?>
        <tr>
          <td class="border"><?= $no ?></td>
          <td class="border"><?= $ss->invoice ?></td>
          <td class="border"><?= date_format($datetime, 'd/m/Y') ?></td>
          <td class="border"><?= date_format($datetime, 'H:s:i') ?></td>
          <td class="border"><?= $ss->username ?></td>
          <td class="border"><?= $ss->name_customer ?></td>
          <td class="border" align="right"><?= rupiah($ss->total) ?></td>
          <td class="border" align="right"><?= rupiah($ss->untung) ?></td>
        </tr>
      <?php $no++;
        endforeach ?>
          <tr>
            <th class="border" colspan="6" align="right">T O T A L : </th>
            <th class="border" align="right"><?= rupiah($total) ?></th>
            <th class="border" align="right"><?= rupiah($lr) ?></th>
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