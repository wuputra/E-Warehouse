<?php

$rg = new lsp();
$table = "table_user";
$autokode = $rg->autokode($table, "kd_user", "US");
$data = $rg->select($table);

if (isset($_POST['btnInput'])) {
    $kd_user = $_POST['kd_user'];
    $nama_user = $_POST['nama_user'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm = $_POST['confirm'];
    $foto = $_FILES['foto'];
    $level = $_POST['level'];
    $redirect = "?page=kelolaPegawai";


    if ($nama_user == "" || $username == "" || $password == "" || $confirm == "" || $level == "") {
        $response = ['response' => 'negative', 'alert' => 'Lengkapi Field !!!'];
    } else {
        $response = $rg->register($kd_user, $nama_user, $username, $password, $confirm, $foto, $level, $redirect);
    }
}

if (isset($_GET['delete'])) {
    $response = $rg->delete($table, "kd_user", $_GET['id'], "?page=kelolaPegawai");
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
                                    <a href="pageAdmin.php">Home</a>
                                </li>
                                <li class="list-inline-item seprate">
                                    <span>/</span>
                                </li>
                                <li class="list-inline-item">Kelola Pegawai</li>
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
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <strong class="card-title mb-3">Input Pegawai</strong>
                        </div>
                        <div class="card-body">
                            <form method="post" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label>Kode User</label>
                                    <input style="color: #254744; font-weight: bold;" class="au-input au-input--full"
                                        type="text" name="kd_user" readonly value="<?= $autokode; ?>">
                                </div>
                                <div class="form-group">
                                    <label>Nama Pegawai</label>
                                    <input class="au-input au-input--full" required type="text" name="nama_user"
                                        placeholder="Nama Pegawai">
                                </div>
                                <div class="form-group">
                                    <label>Username</label>
                                    <input class="au-input au-input--full" required type="text" name="username"
                                        placeholder="Username">
                                </div>
                                <div class="form-group">
                                    <label>Password</label>
                                    <input class="au-input au-input--full" required type="password" name="password"
                                        placeholder="Password">
                                </div>
                                <div class="form-group">
                                    <label>Confirm Password</label>
                                    <input class="au-input au-input--full" required type="password" name="confirm"
                                        placeholder="Confirm Password">
                                </div>
                                <div class="form-group">
                                    <label for="foto_karyawan" class="control-label mb-1">Foto</label>
                                    <div style="padding-bottom: 15px;">
                                        <img alt="" width="120" class="img-responsive" id="pict">
                                    </div>
                                    <input required type="file" name="foto" id="gambar" class="form-control-file">
                                </div>
                                <div class="form-group">
                                    <label for="level" class="control-label mb-1">Hak Akses</label>
                                    <select name="level" class="form-control mb-1">
                                        <option value="">Pilih Hak Akses</option>
                                        <option value="Admin">Admin</option>
                                        <option value="Network Engineer">Network Engineer</option>
                                        <option value="Hardware">Hardware</option>
                                    </select>
                                </div>
                                <button type="submit" name="btnInput" class="btn btn-primary"><i
                                        class="fa fa-download"></i> Simpan</button>
                                <button type="reset" name="btnRegister" class="btn btn-danger"><i
                                        class="fa fa-eraser"></i> Reset</button>

                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <strong class="card-title mb-3">Data Pegawai</strong>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="example" class="table table-borderless table-striped table-earning">
                                    <thead>
                                        <tr style="text-align: center;">
                                            <th>No</th>
                                            <th>Kode Pegawai</th>
                                            <th>Nama Pegawai</th>
                                            <th>Username</th>
                                            <th>Hak Akses</th>
                                            <th>Foto</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no = 1;
                                        foreach ($data as $dataB) {
                                            ?>
                                            <tr>
                                                <td style="text-align: center;"><?= $no; ?></td>
                                                <td style="text-align: center;"><?= $dataB['kd_user']; ?></td>
                                                <td><?= $dataB['nama_user'] ?></td>
                                                <td><?= $dataB['username'] ?></td>
                                                <td style="text-align: center;"><?= $dataB['level'] ?></td>
                                                <td style="text-align: center;"><img width="60"
                                                        src="img/<?= $dataB['foto_user'] ?>" alt=""></td>
                                                <td style="text-align: center;">
                                                    <div class="table-data-feature">
                                                        <button id="btnDelete<?php echo $no; ?>" class="item"
                                                            data-toggle="tooltip" data-placement="top" title="Delete">
                                                            <i class="zmdi zmdi-delete"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                            <script src="vendor/jquery-3.2.1.min.js"></script>
                                            <script>
                                                $('#btnDelete<?php echo $no; ?>').click(function (e) {
                                                    e.preventDefault();
                                                    swal({
                                                        title: "Hapus",
                                                        text: "Yakin ingin menghapus?",
                                                        type: "error",
                                                        showCancelButton: true,
                                                        confirmButtonText: "Yes",
                                                        cancelButtonText: "Cancel",
                                                        closeOnConfirm: false,
                                                        closeOnCancel: true
                                                    }, function (isConfirm) {
                                                        if (isConfirm) {
                                                            window.location.href = "?page=kelolaPegawai&delete&id=<?php echo $dataB['kd_user'] ?>";
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