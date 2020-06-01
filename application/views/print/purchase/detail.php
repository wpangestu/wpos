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
      <td align="center">Laporan Pembelian Detail</td>
    </tr>
    <tr>
      <td align="center" style="font-weight: bold">
          <?= $getinvoice ?>
      </td>
    </tr>
  </table>
  <?php $pd = $purchase_detail->result() ?>
  <?php $datetime = date_create($pd[0]->datetime_purchase) ?>
  <table width="100%">
    <tr>
      <th width="20px">Tanggal</th>
      <td style="padding-left:50px">: <?= date_format($datetime, 'd/m/Y') ?></td>
      <th align="right">User</th>
      <td style="padding-left:50px">: <?= $pd[0]->username ?></td>
    </tr>
    <tr>
      <th width="20px">Supplier</th>
      <td style="padding-left:50px">: <?= $pd[0]->name ?></td>
      <th align="right">Jam</th>
      <td style="padding-left:50px">: <?= date_format($datetime, 'H.i') ?></td>
    </tr>
  </table>
  <table class="border" width="100%">
    <tr style="background-color: greenyellow">
      <th width="10px" class="border">No</th>
      <th width="100px" class="border">Kode Barang</th>
      <th class="border">Nama Barang</th>
      <th width="10px" class="border">Harga</th>
      <th class="border" width="10px">Qty</th>
      <th class="border">Sub Total</th>
    </tr>
    <?php $total=0; $no=1; foreach($purchase_detail->result() as $pd) : ?>
    <?php $total += $pd->sub_total ?>
    <tr>
      <td class="border"><?= $no ?></td>
      <td class="border"><?= $pd->kode_product ?></td>
      <td class="border"><?= $pd->name_product ?></td>
      <td align="right" class="border"><?= rupiah($pd->price) ?></td>
      <td class="border" align="right"><?= $pd->qty ?></td>
      <td align="right" class="border"><?= rupiah($pd->sub_total) ?></td>
    </tr>
    <?php $no++; endforeach ?>
    <tr>
      <th colspan="5" class="border" align="right">T O T A L :</th>
      <th class="border" align="right"><?= rupiah($total) ?></th>
    </tr>
  </table>
  <table>
    <tr><td class="miring">Create at</td><td class="miring">: <?= date('d/m/Y H:i:s') ?></td></tr>
    <tr><td class="miring">Create by</td><td class="miring">: <?= getuser()->username ?></td></tr>
  </table>
</body>
</html>