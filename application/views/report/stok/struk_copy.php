<!DOCTYPE html>
<html lang="en">

<head>
  <title>Struk</title>
  <style>
  body{
    width: 58mm;
    /* width: 76mm; */
    /* border: 1px solid black; */
    font-family: Arial, Helvetica, sans-serif;
  }
  </style>
</head>

<body>
  <div style="text-align: center"><?= getsetting()->nm_toko ?></div>
  <div style="text-align: center"><?= getsetting()->keterangan_toko ?></div>
  <div style="text-align: center">----------------------------------------</div>
  <!-- <div style="text-align: left">Tgl:04/02/2020</div>
  <div style="text-align: left">No#:10.19.0019</div> -->
  <table width="100%">
    <tr>
      <td align="right">Tgl:</td>
      <td>04/02/2020</td>
      <td align="right">Kasir:</td>
      <td>admin</td>
    </tr>
    <tr>
      <td align="right">No#:</td>
      <td>10.19.0019</td>
      <td align="right">Jam:</td>
      <td>15.00</td>
    </tr>
  </table>
  <div style="text-align: center">----------------------------------------</div>
  <!-- <div style="text-align: left">CAFFINO 20GR</div>
  <div style="text-align: left">5 PC X 1.200 = Rp 6.000</div> -->
  <table width="100%">
    <tr>
      <td colspan="5">CAFFINO 20GR</td>
    </tr>
    <tr>
      <td align="right">5 PC</td><td>X</td><td align="right">1.200</td><td align="right">= Rp</td><td align="right">6.000</td>
    </tr>
    <tr>
      <td colspan="5">Disc. -1.000</td>
    </tr>
    <tr>
      <td colspan="5">CAFFINO 20GR</td>
    </tr>
    <tr>
      <td align="right">12 PC</td><td>X</td><td align="right">32.200</td><td align="right">= Rp</td><td align="right">120.000</td>
    </tr>
    <!-- PEMBAYARAN -->
    <tr>
      <td colspan="5">---------------------------------------</td>
    </tr>
    <tr>
      <td colspan="3">Total Item</td><td align="right">= Rp</td><td align="right">126.000</td>
    </tr>
    <tr>
      <td colspan="3">Total Disc.</td><td align="right">= Rp</td><td align="right">5.000</td>
    </tr>
    <tr>
      <td colspan="3">Total Belanja</td><td align="right">= Rp</td><td align="right">121.000</td>
    </tr>
    <tr>
      <td colspan="3">Bayar</td><td align="right">= Rp</td><td align="right">125.000</td>
    </tr>
    <tr>
      <td colspan="3">Kembali</td><td align="right">= Rp</td><td align="right">4.000</td>
    </tr>
  </table>
  <div style="text-align: center">----------------------------------------</div>
  <div style="text-align: center"><?= getsetting()->footer_struk ?></div>
</body>
<script>
  window.print();
</script>

</html>