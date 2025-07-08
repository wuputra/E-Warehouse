<?php
include '../config/controller.php';
$qb = new lsp();
session_start();

$id = $_GET['id'] ?? null;
if (!$id) die("ID tidak ditemukan.");

$dataPre = $qb->selectWhere("table_pretransaksi", "kd_pretransaksi", $id);
if (!$dataPre) die("Data tidak ditemukan untuk ID: $id");

$dataBarang = $qb->select("table_barang");
$barangMap = [];
foreach ($dataBarang as $barang) {
    $barangMap[$barang['kd_barang']] = $barang['nama_barang'];
}
$namaBarang = $barangMap[$dataPre['kd_barang']] ?? 'Tidak ditemukan';

$auth = $qb->AuthUser($_SESSION['username']);
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>CETAK PEMAKAIAN BARANG JARINGAN</title>
    <link rel="icon" href="../favicon.ico" type="image/x-icon">
    <style>
        @page {
            size: 70mm 40mm;
            margin: 0;
        }

        html,
        body {
            margin: 0;
            padding: 0;
            width: 70mm;
            height: 40mm;
            font-family: 'Segoe UI', sans-serif;
            font-size: 7pt;
            color: #000;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .etiket {
            width: 64mm;
            height: 34mm;
            box-sizing: border-box;
            border: 1px solid #000000;
            padding: 1mm;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
        }

        .header {
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .header img {
            height: 8mm;
            flex-shrink: 0;
        }

        .title {
            font-weight: bold;
            font-size: 7pt;
            line-height: 1.1;
            color: #254744;
        }

        .subheader {
            font-weight: bold;
            font-size: 5.6pt;
            margin-top: 1mm;
            color: #000000;
        }

        .separator {
            border-top: 1px solid #000000;
            margin: 1mm 0 1.0mm 0;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
        }

        .info-table td {
            padding: 0.1mm 0;
            vertical-align: top;
        }

        .label-col {
            width: 22mm;
            font-weight: bold;
        }

        .colon-col {
            width: 1.5mm;
            padding-left: 0;
            padding-right: 0.5mm;
            text-align: left;
        }

        .value-col {
            word-break: break-word;
        }

        /* Warna khusus untuk baris kode antrian */
        .highlight-label {
            font-weight: bold;
            color: #000000;
        }

        .highlight-value {
            font-weight: bold;
            color: #000000;
        }
    </style>
</head>

<body onload="window.print()">
    <div class="etiket">
        <div class="header">
            <img src="../../whsimrs/images/icon/logo-kartubarang.png" alt="Logo RS">
            <div>
                <div class="title">KARTU PEMAKAIAN BARANG JARINGAN</div>
                <div class="subheader">E-WAREHOUSE SIMRS RSUD MOHAMMAD NATSIR</div>
            </div>
        </div>
        <div class="separator"></div>
        <table class="info-table">
            <tr>
                <td class="label-col highlight-label">Kode Antrian</td>
                <td class="colon-col highlight-label">:</td>
                <td class="value-col highlight-value"><?= htmlspecialchars($dataPre['kd_pretransaksi']) ?></td>
            </tr>
            <tr>
                <td class="label-col">Nama Barang</td>
                <td class="colon-col">:</td>
                <td class="value-col"><?= htmlspecialchars($namaBarang) ?></td>
            </tr>
            <tr>
                <td class="label-col">Penyalur</td>
                <td class="colon-col">:</td>
                <td class="value-col"><?= htmlspecialchars($auth['nama_user']) ?></td>
            </tr>
            <tr>
                <td class="label-col">Tanggal Diterima</td>
                <td class="colon-col">:</td>
                <td class="value-col"><?= htmlspecialchars($dataPre['tanggal_keluar']) ?></td>
            </tr>
            <tr>
                <td class="label-col">Penerima</td>
                <td class="colon-col">:</td>
                <td class="value-col"><?= htmlspecialchars($dataPre['penerima']) ?></td>
            </tr>
            <tr>
                <td class="label-col">Penempatan</td>
                <td class="colon-col">:</td>
                <td class="value-col"><?= htmlspecialchars($dataPre['penempatan']) ?></td>
            </tr>
        </table>
    </div>
</body>

</html>
