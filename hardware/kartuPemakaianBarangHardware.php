<?php
$qb = new lsp();
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($_GET['id'])) {
    die("Kode antrian tidak ditemukan di URL.");
}

$id = $_GET['id'];

// Ambil data transaksi berdasarkan kd_pretransaksi
$dataPre = $qb->selectWhere("table_pretransaksi_hardware", "kd_pretransaksi", $id);
if (!$dataPre) {
    die("Data tidak ditemukan untuk kode antrian: $id");
}

// Ambil semua data barang untuk pemetaan
$dataBarang = $qb->select("table_barang_hardware");

// Buat array kd_barang => nama_barang
$barangMap = [];
foreach ($dataBarang as $barang) {
    $barangMap[$barang['kd_barang']] = $barang['nama_barang'];
}

// Ambil nama barang dari mapping
$namaBarang = isset($barangMap[$dataPre['kd_barang']]) ? $barangMap[$dataPre['kd_barang']] : 'Tidak ditemukan';

if ($_SESSION['level'] != "Hardware") {
    // header("location:../index.php");
}
?>


<style>
    @media print {
        .ds {
            display: none;
        }

        .card {
            box-shadow: none;
            border: none;
        }
    }
</style>

<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card text-center">
                        <div class="card-header">
                            <h4>Kartu Pemakaian Barang Hardware</h4>
                            <p>E-Warehouse SIMRS RSUD Mohammad Natsir</p>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col text-left">
                                    <strong>Kode Antrian:</strong> <?= htmlspecialchars($id) ?>
                                </div>
                                <div class="col text-right">
                                    <strong>Tanggal Cetak:</strong> <?= date("Y-m-d") ?>
                                </div>
                            </div>

                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Kode Barang</th>
                                        <th>Nama Barang</th>
                                        <th>Jumlah</th>
                                        <th>Tanggal Keluar</th>
                                        <th>Penempatan</th>
                                        <th>Penerima</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td style="text-align: center;"><?= $dataPre['kd_barang'] ?></td>
                                        <td><?= $namaBarang ?></td>
                                        <td style="text-align: center;"><?= $dataPre['jumlah'] ?></td>
                                        <td style="text-align: center;"><?= $dataPre['tanggal_keluar'] ?></td>
                                        <td><?= $dataPre['penempatan'] ?></td>
                                        <td><?= $dataPre['penerima'] ?></td>
                                    </tr>
                                </tbody>
                            </table>

                            <br>
                            <a href="hardware/cetakkartubaranghardware.php?id=<?= $dataPre['kd_pretransaksi'] ?>"
                                target="_blank" class="btn btn-primary">

                                <i class="fa fa-print"></i> Cetak Kartu
                            </a>
                            <a href="javascript:history.back()" class="btn btn-danger ds"><i class="fa fa-repeat"></i>
                                Kembali</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>