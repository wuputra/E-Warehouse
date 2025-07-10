<!DOCTYPE html>
<html lang="en">

<head>
    <title>Dashboard Admin</title>
    <link rel="stylesheet" type="text/css"
        href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../css/mains.css">
</head>
<style>
    body {
        overflow-x: hidden;
    }
</style>

<body onload="window.print();">
    <?php
    include "../config/controller.php";
    $qb = new lsp();
    if (!isset($_GET['dateAwal']) || !isset($_GET['dateAkhir'])) {
        header("location:../Page.php?page=BarangPertanggal");
    }
    $whereparam = "tanggal_masuk";
    $param = $_GET['dateAwal'];
    $param1 = $_GET['dateAkhir'];
    $dataB = $qb->selectBetween("detailbarang", $whereparam, $param, $param1);
    ?>
    <div class="row" style="text-align: center;">
        <div class="col-sm-12" style="padding: 50px;">
            <h2>REPORT KETERSEDIAAN BARANG PER-TANGGAL</h2>
            <h2>NETWORK WAREHOUSE SIMRS </h2>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12" style="padding: 50px;">
            <p class="text-right">Dari Tanggal: <?php echo $_GET['dateAwal']; ?> Ke Tanggal:
                <?php echo $_GET['dateAkhir'] ?></p>
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th style="text-align: center;">Kode Barang</th>
                        <th style="text-align: center;">Nama Barang</th>
                        <th style="text-align: center;">Merek Barang</th>
                        <th style="text-align: center;">Distributor</th>
                        <th style="text-align: center;">Tanggal Masuk</th>
                        <th style="text-align: center;">Stok</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (count(@$dataB) > 0) {
                        $no = 1;
                        foreach (@$dataB['data'] as $ds) { ?>
                            <tr>
                                <td style="text-align: center;"><?= $ds['kd_barang'] ?></td>
                                <td><?= $ds['nama_barang'] ?></td>
                                <td style="text-align: center;"><?= $ds['merek'] ?></td>
                                <td style="text-align: center;"><?= $ds['nama_distributor'] ?></td>
                                <td style="text-align: center;"><?= $ds['tanggal_masuk'] ?></td>
                                <td style="text-align: center;"><?= $ds['stok_barang'] ?></td>
                            </tr>
                            <?php $no++;
                        } ?>
                        <tr style="text-align: center;">
                            <td colspan="4"></td>
                            <td>Jumlah</td>
                            <td>
                                <?php foreach ($dataB['jumlah'] as $datas): ?>
                                    <?php echo $datas; ?>
                                <?php endforeach ?>
                        </tr>
                    <?php } else { ?>
                        <tr>
                            <td colspan="6" class="text-center">Tidak ada barang di periode ini</td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            <p>Tanggal Cetak Report : <?= date("Y-m-d"); ?></p>
        </div>
    </div>
</body>

</html>