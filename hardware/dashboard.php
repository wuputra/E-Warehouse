<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$pg = new lsp();

// Cek hak akses
if ($_SESSION['level'] != "Hardware") {
    header("location:../index.php");
}

// Ambil data
$barang = $pg->selectCount("table_barang_hardware", "kd_barang");
$merek = $pg->getCountRows("table_merek");
$distributor = $pg->getCountRows("table_distributor");
$transaksi = $pg->selectCount("table_pretransaksi_hardware", "kd_pretransaksi");
$terjual = $pg->selectCount("table_transaksi_hardware", "jumlah_beli");
$totstock = $pg->selectSum("table_barang_hardware", "stok_barang");
$totusage = $pg->selectSum("table_pretransaksi_hardware", "jumlah");
?>
<section class="au-breadcrumb m-t-75">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <div class="au-breadcrumb-content">
                        <div class="au-breadcrumb-left">
                            <ul class="list-unstyled list-inline au-breadcrumb__list">
                                <li class="list-inline-item active">
                                    <a href="pageNetwork.php">Home</a>
                                </li>
                                <li class="list-inline-item seprate">
                                    <span>/</span>
                                </li>
                                <li class="list-inline-item">Dashboard</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row" style="margin-top: -120px;">

                <!-- Barang -->
                <div class="col-sm-6 col-lg-3">
                    <a href="pageHardware.php?page=viewBarangHardware" style="text-decoration: none; color: inherit;">
                        <div class="overview-item overview-item--c6">
                            <div class="overview__inner">
                                <div class="overview-box clearfix">
                                    <div class="icon">
                                        <i class="fas fa-server"></i>
                                    </div>
                                    <div class="text">
                                        <h2><?= $barang['count'] ?></h2>
                                        <span>Hardware Data</span>
                                    </div>
                                </div>
                                <div class="overview-chart">
                                    <canvas id="widgetChart6"></canvas>
                                </div>
                            </div>
                        </div>
                </div>

                <!-- Report Stock Barang -->
                <a href="pageHardware.php?page=reportStockBarangHardware"
                    style="text-decoration: none; color: inherit;">
                    <div class="overview-item overview-item--c6">
                        <div class="overview__inner">
                            <div class="overview-box clearfix">
                                <div class="icon">
                                    <i class="fas fa-chart-pie"></i>
                                </div>
                                <div class="text">
                                    <h2><?= number_format($totstock['sum'] ?? 0); ?></h2>
                                    <span>Stock Report</span>
                                </div>
                            </div>
                            <div class="overview-chart">
                                <canvas id="widgetChart6"></canvas>
                            </div>
                        </div>
                    </div>
                </a>

                <!-- Barang Terjual -->
                <div class="col-sm-6 col-lg-3">
                    <a href="pageHardware.php?page=viewPemakaianBarangHardware"
                        style="text-decoration: none; color: inherit;">
                        <div class="overview-item overview-item--c6">
                            <div class="overview__inner">
                                <div class="overview-box clearfix">
                                    <div class="icon">
                                        <i class="fas fa-cube"></i>
                                    </div>
                                    <div class="text">
                                        <h2><?= $transaksi['count']; ?></h2>
                                        <span>Hardware Item Usage</span>
                                    </div>
                                </div>
                                <div class="overview-chart">
                                    <canvas id="widgetChart6"></canvas>
                                </div>
                            </div>
                        </div>
                </div>

                <!-- Report Pemakaian Barang -->
                <a href="pageHardware.php?page=reportPemakaianBarangHardware"
                    style="text-decoration: none; color: inherit;">
                    <div class="overview-item overview-item--c6">
                        <div class="overview__inner">
                            <div class="overview-box clearfix">
                                <div class="icon">
                                    <i class="fas fa-chart-line"></i>
                                </div>
                                <div class="text">
                                    <h2><?= number_format($totusage['sum'] ?? 0); ?></h2>
                                    <span>Item Usage Report</span>
                                </div>
                            </div>
                            <div class="overview-chart">
                                <canvas id="widgetChart6"></canvas>
                            </div>
                        </div>
                    </div>
                </a>
            </div> <!-- end row -->
        </div>
    </div>
</div>