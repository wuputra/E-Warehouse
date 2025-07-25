<?php
$qb = new lsp();
$dataB = $qb->select("detailbarang");
if ($_SESSION['level'] != "Network Engineer") {
    header("location:../index.php");
}
if (isset($_GET['delete'])) {
    $response = $qb->delete("table_barang", "kd_barang", $_GET['id'], "?page=viewBarang");
}
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<section class="au-breadcrumb m-t-75">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="au-breadcrumb-content">
                        <div class="au-breadcrumb-left">
                            <ul class="list-unstyled list-inline au-breadcrumb__list">
                                <li class="list-inline-item active">
                                    <a href="pageNetwork.php">Home</a>
                                </li>
                                <li class="list-inline-item seprate">
                                    <span>/</span>
                                </li>
                                <li class="list-inline-item">Data Barang / Barang Network</li>
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
                                <i class="fas fa-network-wired"></i></i>Barang Network
                            </h3>
                        </div>
                        <div class="card-body">
                            <a href="?page=addBarang" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah
                                Barang</a>
                            </button>
                            <br>
                            <br>
                            <div class="table-responsive">
                                <table id="example" class="table table-borderless table-striped table-earning">
                                    <thead>
                                        <tr style="text-align: center;">
                                            <th>Kode Barang</th>
                                            <th>Nama Barang</th>
                                            <th>Merek</th>
                                            <th>Distributor</th>
                                            <th>Tanggal Masuk</th>
                                            <th>Harga</th>
                                            <th>Stock</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no = 1;
                                        foreach ($dataB as $ds) {
                                            ?>
                                            <tr>
                                                <td style="text-align: center;"><?= $ds['kd_barang'] ?></td>
                                                <td><?= $ds['nama_barang'] ?></td>
                                                <td style="text-align: center;"><?= $ds['merek'] ?></td>
                                                <td style="text-align: center;"><?= $ds['nama_distributor'] ?></td>
                                                <td style="text-align: center;"><?= $ds['tanggal_masuk'] ?></td>
                                                <td style="text-align: center;">
                                                    <?= "Rp" . number_format($ds['harga_barang']) ?></td>
                                                <td style="text-align: center;"><?= $ds['stok_barang'] ?></td>
                                                <td class="text-center">
                                                    <div class="btn-group">
                                                        <a href="?page=viewBarangDetail&id=<?php echo $ds['kd_barang'] ?>"
                                                            data-toggle="tooltip" data-placement="top" title="Detail"
                                                            class="btn btn-warning"><i class="fa fa-search"></i></a>
                                                        <a href="?page=viewBarangEdit&edit&id=<?= $ds['kd_barang'] ?>"
                                                            data-toggle="tooltip" data-placement="top" title="Edit"
                                                            class="btn btn-info"><i class="fa fa-edit"></i></a>
                                                        <button data-toggle="tooltip" data-placement="top" title="Delete"
                                                            href="<a href="
                                                            ?page=viewBarangEdit&hapust&id=<?= $ds['kd_barang'] ?>""
                                                            class="btn btn-danger">
                                                            <i class="fa fa-trash" id="btdelete<?php echo $no; ?>"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                            <script src="vendor/jquery-3.2.1.min.js"></script>
                                            <script>
                                                $('#btdelete<?php echo $no; ?>').click(function (e) {
                                                    e.preventDefault();
                                                    swal({
                                                        title: "Hapus",
                                                        text: "Yakin Hapus?",
                                                        type: "warning",
                                                        showCancelButton: true,
                                                        confirmButtonText: "Ya",
                                                        cancelButtonText: "Tidak",
                                                        closeOnConfirm: false,
                                                        closeOnCancel: true
                                                    }, function (isConfirm) {
                                                        if (isConfirm) {
                                                            window.location.href = "?page=viewBarang&delete&id=<?php echo $ds['kd_barang'] ?>";
                                                        }
                                                    });
                                                });
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