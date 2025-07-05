<!DOCTYPE html>
<html lang="en">

<head>
  <title>REPORT PEMAKAIAN BARANG HARDWARE</title>
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
  $dataPre = $qb->select("table_pretransaksi_hardware");
  $dataBarang = $qb->select("table_barang_hardware");

  // Buat array pencarian kd_barang -> nama_barang
  $barangMap = [];
  foreach ($dataBarang as $barang) {
    $barangMap[$barang['kd_barang']] = $barang['nama_barang'];
  }
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
      <h2 style="text-align: center;">REPORT PEMAKAIAN BARANG HARDWARE</h2>
      <h2 style="text-align: center;">E-WAREHOUSE SIMRS RSUD MOHAMMAD NATSIR</h2>
      <p class="text-right">Tanggal Cetak: <?php echo date("Y-m-d"); ?></p>
      <table border="1" cellspacing="0" width="100%;" cellpadding="5">
        <thead>
          <tr>
            <th>Kode Antrian</th>
            <th>Kode Barang</th>
            <th>Nama Barang</th>
            <th>Spesfikasi Barang</th>
            <th>Jumlah</th>
            <th>Tanggal Keluar</th>
            <th>Penempatan</th>
            <th>Penerima</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $no = 1;
          foreach ($dataPre as $ds) {
            $namaBarang = isset($barangMap[$ds['kd_barang']]) ? $barangMap[$ds['kd_barang']] : 'Tidak ditemukan'; ?>
            <tr>
              <td style="text-align: center;"><?= $ds['kd_pretransaksi'] ?></td>
              <td style="text-align: center;"><?= $ds['kd_barang'] ?></td>
              <td><?= $namaBarang ?></td>
              <td style="text-align: justify">
                <?php
                $barang = $qb->selectWhere("table_barang_hardware", "kd_barang", $ds['kd_barang']);
                echo nl2br(htmlspecialchars($barang['spesifikasi']));
                ?>
              </td>
              <td style="text-align: center;"><?= $ds['jumlah'] ?></td>
              <td style="text-align: center;"><?= $ds['tanggal_keluar'] ?></td>
              <td><?= $ds['penempatan'] ?></td>
              <td><?= $ds['penerima'] ?></td>
            </tr>
            <?php $no++;
          } ?>
      </table>
    </div>
  </div>

</body>

</html>