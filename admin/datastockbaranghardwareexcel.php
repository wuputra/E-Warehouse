<!DOCTYPE html>
<html lang="en">

<head>
  <title>REPORT STOCK BARANG HARDWARE</title>
  <link rel="icon" href="../favicon.ico" type="image/x-icon">
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
  $dataB = $qb->select("table_barang_hardware");
  $totbal = $qb->selectSum("table_barang_hardware", "stok_barang");
  $total = $qb->selectCount("table_barang_hardware", "kd_barang");
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
      <h2 style="text-align: center;">REPORT STOCK BARANG HARDWARE</h2>
      <h2 style="text-align: center;">E-WAREHOUSE SIMRS RSUD MOHAMMAD NATSIR</h2>
      <p class="text-right">Tanggal Cetak: <?php echo date("Y-m-d"); ?></p>
      <table border="1" cellspacing="0" width="100%;" cellpadding="5">
        <thead>
          <tr>
            <th>Kode Barang</th>
            <th>Nama Barang</th>
            <th>Spesfikasi Barang</th>
            <th>Merek Barang</th>
            <th>Distributor</th>
            <th>Tanggal Update</th>
            <th>Stock</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $no = 1;
          foreach ($dataB as $ds) { ?>
            <tr>
              <td style="text-align: center;"><?= $ds['kd_barang'] ?></td>
              <td><?= $ds['nama_barang'] ?></td>
              <td style="text-align: justify">
                <?php
                $barang = $qb->selectWhere("table_barang_hardware", "kd_barang", $ds['kd_barang']);
                echo nl2br(htmlspecialchars($barang['spesifikasi']));
                ?>
              </td>
              <td style="text-align: center;">
                <?php
                $kd_merek = $ds['kd_merek'];
                $query = mysqli_query($con, "SELECT merek FROM table_merek WHERE kd_merek = '$kd_merek'");
                $result = mysqli_fetch_assoc($query);
                echo $result['merek'];
                ?>
              </td>
              <td style="text-align: center;">
                <?php
                $kd_distributor = $ds['kd_distributor'];
                $query = mysqli_query($con, "SELECT nama_distributor FROM table_distributor WHERE kd_distributor = '$kd_distributor'");
                $result = mysqli_fetch_assoc($query);
                echo $result['nama_distributor'];
                ?>
              </td>
              <td style="text-align: center;"><?= $ds['tanggal_masuk'] ?></td>
              <td style="text-align: center;"><?= $ds['stok_barang'] ?></td>
              <?php $no++;
          } ?>
        </tbody>
        <tr>
          <td colspan="6">Total Barang Tersimpan</td>
          <td style="text-align: center;"><?php echo $totbal['sum']; ?></td>
        </tr>
        <tr>
          <td colspan="6">Jumlah Model Barang</td>
          <td style="text-align: center;"><?php echo $total['count']; ?></td>
        </tr>
      </table>
    </div>
  </div>

</body>

</html>