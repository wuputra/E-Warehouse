<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$pg = new lsp();

// Cek hak akses
if ($_SESSION['level'] != "Admin") {
    header("location:../index.php");
}

// Ambil data
$distributor = $pg->getCountRows("table_distributor");
$merek = $pg->getCountRows("table_merek");
$barang = $pg->selectCount("table_barang", "kd_barang");
$barang_hardware = $pg->selectCount("table_barang_hardware", "kd_barang");
$pegawai = $pg->selectCount("table_user", "kd_user");
$transaksi = $pg->selectCount("table_pretransaksi", "kd_pretransaksi");
$transaksi_hardware = $pg->selectCount("table_pretransaksi_hardware", "kd_pretransaksi");
$terjual = $pg->selectCount("table_transaksi", "jumlah_beli");
$totstocknet = $pg->selectSum("table_barang", "stok_barang");
$totusagenet = $pg->selectSum("table_pretransaksi", "jumlah");
$totstockhard = $pg->selectSum("table_barang_hardware", "stok_barang");
$totusagehard = $pg->selectSum("table_pretransaksi_hardware", "jumlah");
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<section class="au-breadcrumb m-t-75">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <div class="au-breadcrumb-content">
                        <div class="au-breadcrumb-left">
                            <ul class="list-unstyled list-inline au-breadcrumb__list">
                                <li class="list-inline-item active">
                                    <a href="pageAdmin.php">Home</a>
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
                <!-- Data Barang Jaringan -->
                <div class="col-sm-6 col-lg-3">
                    <a href="pageAdmin.php?page=viewBarang" style="text-decoration: none; color: inherit;">
                        <div class="overview-item overview-item--c6">
                            <div class="overview__inner">
                                <div class="overview-box clearfix">
                                    <div class="icon">
                                        <i class="fas fa-network-wired"></i>
                                    </div>
                                    <div class="text">
                                        <h2><?= $barang['count'] ?></h2>
                                        <span>Network Data</span>
                                    </div>
                                </div>
                                <div class="overview-chart">
                                    <canvas id="widgetChart6"></canvas>
                                </div>
                            </div>
                        </div>
                </div>
                <!-- Report Stock Barang -->
                <div class="col-sm-6 col-lg-3">
                    <a href="pageAdmin.php?page=reportStockBarang" style="text-decoration: none; color: inherit;">
                        <div class="overview-item overview-item--c6">
                            <div class="overview__inner">
                                <div class="overview-box clearfix">
                                    <div class="icon">
                                        <i class="fas fa-chart-pie"></i>
                                    </div>
                                    <div class="text">
                                        <h2><?= number_format($totstocknet['sum'] ?? 0); ?></h2>
                                        <span>Network Stock Report</span>
                                    </div>
                                </div>
                                <div class="overview-chart">
                                    <canvas id="widgetChart6"></canvas>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <!-- Data Pemakaian Barang Jaringan -->
                <div class="col-sm-6 col-lg-3">
                    <a href="pageAdmin.php?page=viewPemakaianBarang" style="text-decoration: none; color: inherit;">
                        <div class="overview-item overview-item--c6">
                            <div class="overview__inner">
                                <div class="overview-box clearfix">
                                    <div class="icon">
                                        <i class="fas fa-cube"></i>
                                    </div>
                                    <div class="text">
                                        <h2><?= $transaksi['count']; ?></h2>
                                        <span>Network Item Usage</span>
                                    </div>
                                </div>
                                <div class="overview-chart">
                                    <canvas id="widgetChart6"></canvas>
                                </div>
                            </div>
                        </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <!-- Report Pemakaian Barang Jaringan -->
                    <a href="pageAdmin.php?page=reportPemakaianBarang" style="text-decoration: none; color: inherit;">
                        <div class="overview-item overview-item--c6">
                            <div class="overview__inner">
                                <div class="overview-box clearfix">
                                    <div class="icon">
                                        <i class="fas fa-chart-line"></i>
                                    </div>
                                    <div class="text">
                                        <h2><?= number_format($totusagenet['sum'] ?? 0); ?></h2>
                                        <span>Network Usage Report</span>
                                    </div>
                                </div>
                                <div class="overview-chart">
                                    <canvas id="widgetChart6"></canvas>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <!-- Data Barang Hardware -->
                <div class="col-sm-6 col-lg-3">
                    <a href="pageAdmin.php?page=viewBarangHardware" style="text-decoration: none; color: inherit;">
                        <div class="overview-item overview-item--c6">
                            <div class="overview__inner">
                                <div class="overview-box clearfix">
                                    <div class="icon">
                                        <i class="fas fa-server"></i>
                                    </div>
                                    <div class="text">
                                        <h2><?= $barang_hardware['count'] ?></h2>
                                        <span>Hardware Data</span>
                                    </div>
                                </div>
                                <div class="overview-chart">
                                    <canvas id="widgetChart6"></canvas>
                                </div>
                            </div>
                        </div>
                </div>
                <!-- Report Stock Barang Hardware -->
                <div class="col-sm-6 col-lg-3">
                    <a href="pageAdmin.php?page=reportStockBarangHardware" style="text-decoration: none; color: inherit;">
                        <div class="overview-item overview-item--c6">
                            <div class="overview__inner">
                                <div class="overview-box clearfix">
                                    <div class="icon">
                                        <i class="fas fa-chart-pie"></i>
                                    </div>
                                    <div class="text">
                                        <h2><?= number_format($totstockhard['sum'] ?? 0); ?></h2>
                                        <span>Hardware Stock Report</span>
                                    </div>
                                </div>
                                <div class="overview-chart">
                                    <canvas id="widgetChart6"></canvas>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <!-- Data Pemakaian Barang Hardware -->
                <div class="col-sm-6 col-lg-3">
                    <a href="pageAdmin.php?page=viewPemakaianBarangHardware"
                        style="text-decoration: none; color: inherit;">
                        <div class="overview-item overview-item--c6">
                            <div class="overview__inner">
                                <div class="overview-box clearfix">
                                    <div class="icon">
                                        <i class="fas fa-cube"></i>
                                    </div>
                                    <div class="text">
                                        <h2><?= $transaksi_hardware['count']; ?></h2>
                                        <span>Hardware Item Usage</span>
                                    </div>
                                </div>
                                <div class="overview-chart">
                                    <canvas id="widgetChart6"></canvas>
                                </div>
                            </div>
                        </div>
                </div>
                <!-- Report Pemakaian Barang Hardware -->
                <div class="col-sm-6 col-lg-3">
                    <a href="pageAdmin.php?page=reportPemakaianBarangHardware"
                        style="text-decoration: none; color: inherit;">
                        <div class="overview-item overview-item--c6">
                            <div class="overview__inner">
                                <div class="overview-box clearfix">
                                    <div class="icon">
                                        <i class="fas fa-chart-line"></i>
                                    </div>
                                    <div class="text">
                                        <h2><?= number_format($totusagehard['sum'] ?? 0); ?></h2>
                                        <span>Hardware Usage Report</span>
                                    </div>
                                </div>
                                <div class="overview-chart">
                                    <canvas id="widgetChart6"></canvas>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>