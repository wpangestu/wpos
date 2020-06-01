<!DOCTYPE html>
<html lang="en">

<head>
  <title>Document</title>
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
  <img src="<?php echo $_SERVER['DOCUMENT_ROOT']."/wpos/assets/img/logo.png"?>" style="width: 60px; float: left">
  <table width=100%>
    <tr>
      <th align="center" style="font-size: 25px; font-family: sans-serif">WPOS WEB APPLICATION</th>
    </tr>
    <tr>
      <th align="center" style="font-family: sans-serif;font-size: 15px">Lorem ipsum dolor sit amet consectetur adipisicing elit.</th>
    </tr>
  </table>
  <hr>
  <table width="100%">
    <tr>
      <td align="center">Laporan Pembelian</td>
    </tr>
    <tr>
      <td align="center">21 September 2019</td>
    </tr>
  </table>
  <table class="border" width="100%">
    <tr>
      <td class="border">1</td>
      <td class="border">2</td>
      <td class="border">3</td>
      <td class="border">4</td>
    </tr>
  </table>
</body>
</html>