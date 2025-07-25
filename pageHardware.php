<?php

include "config/controller.php";
$function = new lsp();
session_start();

$auth = $function->AuthUser($_SESSION['username']);


$response = $function->sessionCheck();
if ($response == "false") {
    header("Location:index.php");
}
if (isset($_GET['logout'])) {
    $function->logout();
}

if ($auth['level'] != 'Hardware') {
    header("location:error/403.php");
}

?>
<!DOCTYPE html>
<html>

<head>
    <!-- Title Page-->
    <title>E-WAREHOUSE SIMRS RSUD MOHAMMAD NATSIR</title>
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <!-- Fontfaces CSS-->
    <link href="css/font-face.css" rel="stylesheet" media="all">
    <link href="vendor/font-awesome-4.7/css/font-awesome.min.css" rel="stylesheet" media="all">
    <link href="vendor/font-awesome-5/css/fontawesome-all.min.css" rel="stylesheet" media="all">
    <link href="vendor/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet" media="all">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- Bootstrap CSS-->
    <link href="vendor/bootstrap-4.1/bootstrap.min.css" rel="stylesheet" media="all">

    <!-- Vendor CSS-->
    <link href="vendor/animsition/animsition.min.css" rel="stylesheet" media="all">
    <link href="vendor/bootstrap-progressbar/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet" media="all">
    <link href="vendor/wow/animate.css" rel="stylesheet" media="all">
    <link href="vendor/css-hamburgers/hamburgers.min.css" rel="stylesheet" media="all">
    <link href="vendor/slick/slick.css" rel="stylesheet" media="all">
    <link href="vendor/select2/select2.min.css" rel="stylesheet" media="all">
    <link href="vendor/perfect-scrollbar/perfect-scrollbar.css" rel="stylesheet" media="all">
    <link href="vendor/vector-map/jqvmap.min.css" rel="stylesheet" media="all">
    <link rel="stylesheet" href="css/sweet-alert.css">

    <!-- Main CSS-->
    <link href="css/theme.css" rel="stylesheet" media="all">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">
</head>

<body>

    <div class="page-wrapper">
        <aside class="menu-sidebar2">
            <div class="logo">
                <a href="pageHardware.php">
                    <img src="images/icon/logo-header.png" alt="E-WAREHOUSE SIMRS RSUD MOHAMMAD NATSIR" />
                </a>
            </div>
            <div class="menu-sidebar2__content js-scrollbar1">
                <div class="account2">
                    <div class="image img-cir img-120">
                        <img src="img/<?= $auth['foto_user'] ?>" />
                    </div>
                    <h4 class="name"><?= $auth['nama_user']; ?></h4>
                </div>
                <nav class="navbar-sidebar2">
                    <ul class="list-unstyled navbar__list">
                        <li>
                            <a href="?page">
                                <i class="fas fa-tachometer-alt"></i>Dashboard</a>
                        </li>
                        <li class="has-sub">
                            <a class="js-arrow" href="#">
                                <i class="fas fa-warehouse"></i>Data Barang</a>
                            <ul class="navbar-mobile-sub__list list-unstyled js-sub-list">
                                <li>
                                    <a href="?page=viewBarangHardware">
                                        <i class="fas fa-server"></i></i>Barang Hardware</a>
                                </li>
                                <li>
                                    <a class="nav-link" href="?page=viewMerek">
                                        <i class="fas fa-boxes"></i> Merek Barang
                                    </a>
                                </li>
                                <li>
                                    <a class="nav-link" href="?page=viewDistributor">
                                        <i class="fas fa-truck"></i> Distributor Barang
                                    </a>
                                </li>
                                <li>
                                    <a href="?page=viewPemakaianBarangHardware">
                                        <i class="fas fa-cube"></i>Pemakaian Barang</a>
                                </li>
                            </ul>
                        <li class="has-sub">
                            <a class="js-arrow" href="#">
                                <i class="fas fa-clipboard-list"></i>Report Barang</a>
                            <ul class="navbar-mobile-sub__list list-unstyled js-sub-list">
                                <li>
                                    <a href="?page=reportStockBarangHardware">
                                        <i class="fas fa-chart-pie" title="Chart Report"></i> Stok Barang</a>
                                </li>
                                <li>
                                    <a href="?page=reportPemakaianBarangHardware">
                                        <i class="fas fa-chart-line" title="Analytics Report"></i></i>Barang
                                        Terpakai</a>
                                </li>
                            </ul>
                            <ul class="list-unstyled navbar__list">
                                <li>
                                    <a href="http://192.168.20.222:82/lapor/progres.php" target="blank">
                                        <i class="fas fa-tools"></i>Perbaikan Barang</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>

        <div class="page-container2">
            <header class="header-desktop2">
                <div class="section__content section__content--p30">
                    <div class="container-fluid">
                        <div class="header-wrap2">
                            <div class="logo d-block d-lg-none">
                                <a href="#">
                                    <img src="images/icon/logo-header.png" alt="E-WAREHOUSE SIMRS MOHAMMAD NATSIR" />
                                </a>
                            </div>
                            <div class="header-button2">
                                <div class="header-button-item js-item-menu">
                                    <i class="zmdi zmdi-search"></i>
                                    <div class="search-dropdown js-dropdown">
                                        <form action="">
                                            <input class="au-input au-input--full au-input--h65" type="text"
                                                placeholder="Search for datas &amp; reports..." />
                                            <span class="search-dropdown__icon">
                                                <i class="zmdi zmdi-search"></i>
                                            </span>
                                        </form>
                                    </div>
                                </div>
                                <div class="header-button-item has-noti js-item-menu">
                                    <i class="zmdi zmdi-notifications"></i>
                                    <div class="notifi-dropdown js-dropdown">
                                        <div class="notifi__title">
                                            <p>Notifikasi Terbaru</p>
                                        </div>
                                        <div class="notifi__item">
                                            <div class="bg-c1 img-cir img-40">
                                                <i class="zmdi zmdi-email-open"></i>
                                            </div>
                                            <div class="content">
                                                <p>Welcome to E-Warehouse SIMRS</p>
                                                <span class="date">Now</span>
                                            </div>
                                        </div>
                                        <div class="notifi__item">
                                            <div class="bg-c1 img-cir img-40">
                                                <a href="?page=informasiAplikasi">
                                                    <i class="zmdi zmdi-info-outline"></i>
                                            </div>
                                            <div class="content">
                                                <p>Application Usage Information</p>
                                                <span class="date">Now</span></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="header-button-item mr-0 js-sidebar-btn">
                                    <i class="zmdi zmdi-menu"></i>
                                </div>
                                <div class="setting-menu js-right-sidebar d-none d-lg-block">
                                    <div class="account-dropdown__body">
                                        <div class="account-dropdown__item">
                                            <a href="?page=profile">
                                                <i class="zmdi zmdi-account"></i>Account</a>
                                        </div>
                                        <div class="account-dropdown__item">
                                            <a href="?page=informasiAplikasi">
                                                <i class="fa fa-info-circle"></i> Information</a>
                                        </div>
                                        <div class="account-dropdown__item">
                                            <a href="homepage.php?logout" id="forLogout">
                                                <i class="zmdi zmdi-power"></i>Logout</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
            <aside class="menu-sidebar2 js-right-sidebar d-block d-lg-none">
                <div class="logo">
                    <a href="#">
                        <img src="images/icon/logo-header.png" alt="E-WAREHOUSE SIMRS RSUD MOHAMMAD NATSIR" />
                    </a>
                </div>

            </aside>

            <?php

            @$page = $_GET['page'];
            switch ($page) {
                case 'profile':
                    include "profile.php";
                    break;
                case 'viewPemakaianBarangHardwareEdit':
                    include "hardware/viewPemakaianBarangHardwareEdit.php";
                    break;
                case 'viewDistributor':
                    include "hardware/viewDistributor.php";
                    break;
                case 'viewMerek':
                    include "hardware/viewMerek.php";
                    break;
                case 'reportStockBarangHardware':
                    include "hardware/viewStockBarangHardware.php";
                    break;
                case 'viewBarangHardwareEdit':
                    include "hardware/viewBarangHardwareEdit.php";
                    break;
                case 'viewBarangHardwareDetail':
                    include "hardware/viewBarangHardwareDetail.php";
                    break;
                case 'reportPemakaianBarangHardware':
                    include "hardware/viewBarangHardwareTerpakai.php";
                    break;
                case 'viewPemakaianBarangHardware':
                    include "hardware/viewPemakaianBarangHardware.php";
                    break;
                case 'addPemakaianBarangHardware':
                    include "hardware/addPemakaianBarangHardware.php";
                    break;
                case 'viewBarangHardware':
                    include "hardware/viewBarangHardware.php";
                    break;
                case 'addBarangHardware':
                    include "hardware/addBarangHardware.php";
                    break;
                case 'cetakKartuBarangHardware':
                    include "admin/cetakKartuPemakaianBarangHardware.php";
                    break;
                case 'kartuPemakaianBarangHardware':
                    include "admin/kartuPemakaianBarangHardware.php";
                    break;
                case 'informasiAplikasi':
                    include "admin/informasiAplikasi.php";
                    break;
                default:
                    $page = "dashboard";
                    include "hardware/dashboard.php";
                    break;
            }

            ?>

        </div>

    </div>

    <!-- Jquery JS-->
    <script src="vendor/jquery-3.2.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
    <!-- Bootstrap JS-->
    <script src="vendor/bootstrap-4.1/popper.min.js"></script>
    <script src="vendor/bootstrap-4.1/bootstrap.min.js"></script>
    <!-- Vendor JS -->
    <script src="vendor/slick/slick.min.js">
    </script>
    <script src="vendor/wow/wow.min.js"></script>
    <script src="vendor/animsition/animsition.min.js"></script>
    <script src="vendor/bootstrap-progressbar/bootstrap-progressbar.min.js">
    </script>
    <script src="vendor/counter-up/jquery.waypoints.min.js"></script>
    <script src="vendor/counter-up/jquery.counterup.min.js">
    </script>
    <script src="vendor/circle-progress/circle-progress.min.js"></script>
    <script src="vendor/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="vendor/chartjs/Chart.bundle.min.js"></script>
    <script src="vendor/select2/select2.min.js">
    </script>
    <script src="vendor/vector-map/jquery.vmap.js"></script>
    <script src="vendor/vector-map/jquery.vmap.min.js"></script>
    <script src="vendor/vector-map/jquery.vmap.sampledata.js"></script>
    <script src="vendor/vector-map/jquery.vmap.world.js"></script>

    <!-- Main JS-->
    <script src="js/main.js"></script>
    <script src="js/sweetalert.min.js"></script>
    <script src="js/bootstrap-datepicker.min.js"></script>
    <script>
        $(document).ready(function() {
            function preview(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function(e) {
                        $('#pict').attr('src', e.target.result);
                    }

                    reader.readAsDataURL(input.files[0]);
                }
            }
            $('#gambar').change(function() {
                preview(this);
            })
        });
    </script>
    <script>
        $(document).ready(function() {
            function preview(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function(e) {
                        $('#pict2').attr('src', e.target.result);
                    }

                    reader.readAsDataURL(input.files[0]);
                }
            }
            $('#gambar2').change(function() {
                preview(this);
            })
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#forLogout').click(function(e) {
                e.preventDefault();
                swal({
                    title: "Logout",
                    text: "Yakin Logout?",
                    type: "info",
                    showCancelButton: true,
                    confirmButtonText: "Yes",
                    cancelButtonText: "No",
                    closeOnConfirm: false,
                    closeOnCancel: true
                }, function(isConfirm) {
                    if (isConfirm) {
                        window.location.href = "?logout";
                    }
                });
            });



        })
    </script>
    <script>
        $(document).ready(function() {
            $('#example').DataTable();
        });
    </script>
    <?php include "config/alert.php"; ?>
</body>

</html>
