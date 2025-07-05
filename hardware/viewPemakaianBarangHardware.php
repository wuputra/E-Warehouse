<?php
$qb = new lsp();
$dataPre = $qb->select("table_pretransaksi_hardware");
$dataBarang = $qb->select("table_barang_hardware");

// Buat array pencarian kd_barang -> nama_barang
$barangMap = [];
foreach ($dataBarang as $barang) {
    $barangMap[$barang['kd_barang']] = $barang['nama_barang'];
}


if ($_SESSION['level'] != "Hardware") {
    header("location:../index.php");
}
if (isset($_GET['delete'])) {

    $response = $qb->delete("table_pretransaksi_hardware", "kd_pretransaksi", $_GET['id'], "?page=viewPemakaianBarangHardware");
}
?>
<section class="au-breadcrumb m-t-75">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="au-breadcrumb-content">
                        <div class="au-breadcrumb-left">
                            <ul class="list-unstyled list-inline au-breadcrumb__list">
                                <li class="list-inline-item active">
                                    <a href="pageHardware.php">Home</a>
                                </li>
                                <li class="list-inline-item seprate">
                                    <span>/</span>
                                </li>
                                <li class="list-inline-item">Data Barang / Pemakaian Barang</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="main-content" style="margin-top: -120px;">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="au-card-title" style="background-image:url('images/bg-title-01.jpg');">
                            <div class="bg-overlay bg-overlay--blue"></div>
                            <h3>
                                <i class="fas fa-cube"></i>Data Pemakaian Barang
                            </h3>
                        </div>
                        <div class="card-body">
                            <a href="?page=addPemakaianBarangHardware" class="btn btn-primary"><i
                                    class="fas fa-sign-out-alt"></i> Gunakan Barang</a>
                            </button>
                            <br>
                            <br>
                            <div class="table-responsive">
                                <table id="example" class="table table-borderless table-striped table-earning">
                                    <thead>
                                        <tr style="text-align: center;">
                                            <th>Kode Antrian</th>
                                            <th>Kode Barang</th>
                                            <th>Nama Barang</th>
                                            <th>Jumlah</th>
                                            <th>Tanggal Keluar</th>
                                            <th>Penempatan</th>
                                            <th>Penerima</th>
                                            <th>Action</th>
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
                                                <td style="text-align: center;"><?= $ds['jumlah'] ?></td>
                                                <td style="text-align: center;"><?= $ds['tanggal_keluar'] ?></td>
                                                <td><?= $ds['penempatan'] ?></td>
                                                <td><?= $ds['penerima'] ?></td>
                                                <td class="text-center">
                                                    <a href="#" class="btn btn-danger"
                                                        onclick="confirmDelete('<?= $ds['kd_pretransaksi']; ?>')">
                                                        <i class="fa fa-trash"></i>
                                                    </a>
                                                    <script>
                                                        function confirmDelete(id) {
                                                            swal({
                                                                title: "Hapus",
                                                                text: "Yakin ingin menghapus data ini?",
                                                                type: "warning",
                                                                showCancelButton: true,
                                                                confirmButtonText: "Ya",
                                                                cancelButtonText: "Tidak",
                                                                closeOnConfirm: false,
                                                                closeOnCancel: true
                                                            }, function (isConfirm) {
                                                                if (isConfirm) {
                                                                    window.location.href = "?page=viewPemakaianBarangHardware&delete&id=" + id;
                                                                }
                                                            });
                                                        }
                                                    </script>
                                                    <?php $no++;
                                        } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>