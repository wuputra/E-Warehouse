<?php
$dt = new lsp();
$detail = $dt->selectCustom(" SELECT bh.*, m.merek, m.foto_merek, d.nama_distributor
    FROM table_barang_hardware bh
    JOIN table_merek m ON bh.kd_merek = m.kd_merek
    JOIN table_distributor d ON bh.kd_distributor = d.kd_distributor
    WHERE bh.kd_barang = '" . $_GET['id'] . "'")[0];
if ($_SESSION['level'] != "Admin") {
    header("location:../index.php");
}

?>
<div class="main-content" style="margin-top: 20px;">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <img class="align-self-center mr-3" width="70" src="img/<?php echo $detail['foto_merek'] ?>"
                                alt="">
                            <h4 class="text-right"><?= $detail['nama_barang'] ?></h4>
                        </div>
                        <div class="card-body">
                            <img style="min-height: 200px; width: 100%; display: block;"
                                src="img/<?php echo $detail['gambar'] ?>">
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h3>Detail Barang</h3>
                        </div>
                        <div class="card-body">
                            <table class="table" cellpadding="10" style="width: 100%;">
                                <tr>
                                    <td style="width: 20%;">Kode Barang</td>
                                    <td style="width: 1%;">:</td>
                                    <td style="width: 79%; font-weight: bold; color: #254744;">
                                        <?php echo $detail['kd_barang']; ?></td>
                                </tr>
                                <tr>
                                    <td>Nama Barang</td>
                                    <td>:</td>
                                    <td><?php echo $detail['nama_barang']; ?></td>
                                </tr>
                                <tr>
                                    <td style="width: 20%;">Spesifikasi</td>
                                    <td style="width: 1%;">:</td>
                                    <td style="width: 79%; text-align: justify; line-height: 1.6;">
                                        <?php
                                        // $barang = $dt->selectWhere("table_barang", "kd_barang", $detail['kd_barang']);
                                        echo nl2br(htmlspecialchars($detail['spesifikasi']));
                                        ?>
                                    </td>
                                </tr>

                                <tr>
                                    <td>Merek</td>
                                    <td>:</td>
                                    <td><?php echo $detail['merek']; ?></td>
                                </tr>
                                <tr>
                                    <td>Distributor</td>
                                    <td>:</td>
                                    <td><?php echo $detail['nama_distributor']; ?></td>
                                </tr>
                                <tr>
                                    <td>Tanggal Masuk</td>
                                    <td>:</td>
                                    <td><?php echo $detail['tanggal_masuk']; ?></td>
                                </tr>
                                <tr>
                                    <td>Harga</td>
                                    <td>:</td>
                                    <td><?php echo "Rp. " . number_format($detail['harga_barang']) . ",-"; ?></td>
                                </tr>
                                <tr>
                                    <td>Stok</td>
                                    <td>:</td>
                                    <td><?php echo $detail['stok_barang']; ?></td>
                                </tr>
                                <tr>
                                    <td>Keterangan</td>
                                    <td>:</td>
                                    <td>
                                        <?php
                                        echo ($detail['stok_barang'] < 1) ? "Stock habis" : "Stock tersedia";
                                        ?>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <a href="?page=viewBarangHardware" class="btn btn-danger"><i class="fa fa-repeat"></i> Kembali</a>
        </div>
    </div>
</div>