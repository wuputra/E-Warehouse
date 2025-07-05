<?php
$qb = new lsp();

$dataB = ['data' => []]; // default untuk menghindari undefined variable

if (isset($_POST['btnSearch'])) {
    $whereparam = "tanggal_masuk";
    $param = $_POST['dateAwal'];
    $param1 = $_POST['dateAkhir'];
    $dataB = $qb->selectBetween("detailbarang", $whereparam, $param, $param1);
}
?>

<div class="main-content" style="margin-top: 20px;">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <form method="post">
                            <div class="card-header">
                                <h3>Pilih Tanggal</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <label>Dari Tanggal</label>
                                        <input value="<?= isset($_POST['dateAwal']) ? $_POST['dateAwal'] : '' ?>"
                                            class="form-control" type="date" name="dateAwal" required>
                                    </div>
                                    <div class="col-sm-4">
                                        <label>Ke Tanggal</label>
                                        <input value="<?= isset($_POST['dateAkhir']) ? $_POST['dateAkhir'] : '' ?>"
                                            class="form-control" type="date" name="dateAkhir" required>
                                    </div>
                                </div>
                                <br>
                                <button class="btn btn-primary" name="btnSearch">
                                    <i class="fa fa-search"></i> Search
                                </button>
                                <a href="?page=periode" class="btn btn-danger">Reload</a>
                                <br><br>

                                <?php if (isset($_POST['dateAwal']) && isset($_POST['dateAkhir'])): ?>
                                    <a target="_blank"
                                        href="admin/BarangPeriodePrint.php?dateAwal=<?= urlencode($param) ?>&dateAkhir=<?= urlencode($param1) ?>"
                                        class="btn btn-primary">
                                        <i class="fa fa-print"></i> Print
                                    </a>
                                <?php endif ?>
                                <br><br>

                                <table class="table table-striped table-hover table-bordered">
                                    <thead>
                                        <tr>
                                            <th style="text-align: center;">Kode Barang</th>
                                            <th style="text-align: center;">Nama Barang</th>
                                            <th style="text-align: center;">Merek</th>
                                            <th style="text-align: center;">Distributor</th>
                                            <th style="text-align: center;">Tanggal Masuk</th>
                                            <th style="text-align: center;">Harga</th>
                                            <th style="text-align: center;">Stok</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($dataB['data'])): ?>
                                            <?php foreach ($dataB['data'] as $ds): ?>
                                                <tr>
                                                    <td style="text-align: center;"><?= $ds['kd_barang'] ?></td>
                                                    <td><?= $ds['nama_barang'] ?></td>
                                                    <td style="text-align: center;"><?= $ds['merek'] ?></td>
                                                    <td style="text-align: center;"><?= $ds['nama_distributor'] ?></td>
                                                    <td style="text-align: center;"><?= $ds['tanggal_masuk'] ?></td>
                                                    <td style="text-align: center;"><?= number_format($ds['harga_barang']) ?>
                                                    </td>
                                                    <td style="text-align: center;"> <?= $ds['stok_barang'] ?></td>
                                                </tr>
                                            <?php endforeach ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="7" class="text-center">Tidak ada data</td>
                                            </tr>
                                        <?php endif ?>
                                    </tbody>
                                </table>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>