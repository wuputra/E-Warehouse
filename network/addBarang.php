<?php
$br = new lsp();
if ($_SESSION['level'] != "Network Engineer") {
    header("location:../index.php");
}
$table = "table_barang";
$getMerek = $br->select("table_merek");
$getDistr = $br->select("table_distributor");
$autokode = $br->autokode("table_barang", "kd_barang", "NE");
$waktu = date("Y-m-d");
if (isset($_POST['getSimpan'])) {
    $kode_barang = $br->validateHtml($_POST['kode_barang']);
    $nama_barang = $br->validateHtml($_POST['nama_barang']);
    $merek_barang = $br->validateHtml($_POST['merek_barang']);
    $distributor = $br->validateHtml($_POST['distributor']);
    $harga = $br->validateHtml($_POST['harga']);
    $stok = $br->validateHtml($_POST['stok']);
    $spesifikasi = $br->validateHtml($_POST['spesifikasi']);
    $foto = $_FILES['foto'];
    $ket = $_POST['ket'];

    if ($kode_barang == " " || $nama_barang == " " || $merek_barang == " " || $distributor == " " || $harga == " " || $stok == " " || $foto == " " || $spesifikasi == " " || $ket == " ") {
        $response = ['response' => 'negative', 'alert' => 'lengkapi field'];
    } else {
        if ($harga < 0 || $stok < 0 || $harga == 0 || $stok == 0) {
            $response = ['response' => 'negative', 'alert' => 'Harga atau stok tidak boleh 0 atau <'];
        } else {
            $response = $br->validateImage();
            if ($response['types'] == "true") {
                $value = "'$kode_barang','$nama_barang','$merek_barang','$distributor','$waktu','$harga','$stok','$response[image]',' $spesifikasi','$ket'";

                $response = $br->insert($table, $value, "?page=viewBarang");
            }
        }
    }
}
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<div class="main-content" style="margin-top: 20px;">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <form method="post" enctype="multipart/form-data">
                        <div class="card">
                            <div class="au-card-title" style="background-image:url('images/bg-title-01.jpg');">
                                <div class="bg-overlay bg-overlay--blue"></div>
                                <h3>
                                    <i class="fas fa-network-wired"></i>Form Tambah Barang
                                </h3>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="">Kode Barang</label>
                                            <input type="text" style="font-weight: bold; color: #254744;"
                                                class="form-control" name="kode_barang" value="<?php echo $autokode; ?>"
                                                readonly>
                                        </div>
                                        <div class="form-group">
                                            <label for="">Nama Barang</label>
                                            <input type="text" placeholder="Nama Barang" class="form-control"
                                                name="nama_barang" value="<?php echo @$_POST['nama_barang'] ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="">Merek</label>
                                            <select name="merek_barang" class="form-control">
                                                <option value=" ">Pilih merek</option>
                                                <?php foreach ($getMerek as $mr) { ?>
                                                    <option value="<?= $mr['kd_merek'] ?>"><?= $mr['merek'] ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="">Distributor</label>
                                            <select name="distributor" class="form-control">
                                                <option value=" ">Pilih distributor</option>
                                                <?php foreach ($getDistr as $dr) { ?>
                                                    <option value="<?= $dr['kd_distributor'] ?>">
                                                        <?= $dr['nama_distributor'] ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="">Harga Barang</label>
                                            <input type="number" class="form-control" name="harga">
                                        </div>
                                        <div class="form-group">
                                            <label for="">Stok Barang</label>
                                            <input type="number" class="form-control" name="stok" id="stok">
                                        </div>
                                        <div class="form-group">
                                            <label for="">Foto</label>
                                            <input type="file" class="form-control" name="foto">
                                        </div>
                                        <div class="form-group">
                                            <label for="">Keterangan</label>
                                            <input type="text" class="form-control" name="ket" id="ket" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="">Spesifikasi Barang</label>
                                            <textarea name="spesifikasi" id="spesifikasi" class="form-control" rows="5"
                                                placeholder=""></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer d-flex justify-content-between">
                                <div>
                                    <button name="getSimpan" class="btn btn-primary">
                                        <i class="fa fa-download"></i> Simpan
                                    </button>
                                    <button type="reset" class="btn btn-danger">
                                        <i class="fa fa-eraser"></i> Reset
                                    </button>
                                </div>
                                <a href="?page=viewBarang" class="btn btn-danger">
                                    <i class="fa fa-repeat"></i> Kembali
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('stok').addEventListener('input', function() {
        const stok = parseInt(this.value);
        const ketInput = document.getElementById('ket');

        if (stok < 1 || isNaN(stok)) {
            ketInput.value = 'Stock habis';
        } else {
            ketInput.value = 'Stock tersedia';
        }
    });
</script>