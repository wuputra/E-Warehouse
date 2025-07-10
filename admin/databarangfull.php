<!DOCTYPE html>
<html lang="en">

<head>
  <title>Dashboard Admin</title>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" type="text/css"
    href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<style>
  body {
    overflow-x: hidden;
  }
</style>

<body onload="" style="padding: 20px;">
  <?php
  include "../config/controller.php";
  $qb = new lsp();
  $dataB = $qb->select("detailbarang");
  $totbal = $qb->selectSum("detailbarang", "stok_barang");
  $total = $qb->selectCount("detailbarang", "kd_barang");
  ?>
  <style>
    @media print {
      .btn {
        display: none;
      }
    }
  </style>
  <div class="row">
    <div class="col-sm-12">
      <button class="btn" onclick="window.print()">Print</button>
      <h2>Data Barang</h2>
      <p>Network Warehouse SIMRS</p>
      <p class="text-right">Tanggal Cetak: <?php echo date("Y-m-d"); ?></p>
      <table border="1" cellspacing="0" width="100%;" cellpadding="5">
        <thead>
          <tr>
            <th>Kode Barang</th>
            <th>Nama Barang</th>
            <th>Merek Barang</th>
            <th>Distributor</th>
            <th>Tanggal Masuk</th>
            <th>Stok</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $no = 1;
          foreach ($dataB as $ds) { ?>
            <tr>
              <td style="text-align: center;"><?= $ds['kd_barang'] ?></td>
              <td><?= $ds['nama_barang'] ?></td>
              <td style="text-align: center;"><?= $ds['merek'] ?></td>
              <td style="text-align: center;"><?= $ds['nama_distributor'] ?></td>
              <td style="text-align: center;"><?= $ds['tanggal_masuk'] ?></td>
              <td style="text-align: center;"><?= $ds['stok_barang'] ?></td>
              <?php $no++;
          } ?>
        </tbody>
        <tr>
          <td colspan="5">Total Barang Tersimpan</td>
          <td style="text-align: center;"><?php echo $totbal['sum']; ?></td>
        </tr>
        <tr>
          <td colspan="5">Jumlah Model Barang</td>
          <td style="text-align: center;"><?php echo $total['count']; ?></td>
        </tr>
      </table>
    </div>
  </div>

</body>

</html>