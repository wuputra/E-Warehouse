<?php
$trans = new lsp();
$transkode = $trans->autokode("table_transaksi_hardware", "kd_transaksi", "KP");
$antrian = $trans->autokode("table_pretransaksi_hardware", "kd_pretransaksi", "AN");
$barangs = $trans->select("table_barang_hardware");
$table = "table_pretransaksi_hardware";
if (isset($_GET['getItem'])) {
    $id = $_GET['id'];
    $dataR = $trans->selectWhere("table_barang_hardware", "kd_barang", $id);
}
// $sum       = $trans->selectSum("table_pretransaksi","sub_total");
$sql2 = "SELECT COUNT(kd_pretransaksi) as count FROM table_pretransaksi_hardware WHERE kd_transaksi = '$transkode'";
$exec2 = mysqli_query($con, $sql2);
$assoc2 = mysqli_fetch_assoc($exec2);

if (isset($_POST['btnAdd'])) {
    if (!isset($_SESSION['transaksi'])) {
        $_SESSION['transaksi'] = true;
    }
    $kd_transaksi = $_POST['kd_transaksi'];
    $kd_pretransaksi = $_POST['kd_pretransaksi'];
    $barang = $_POST['kd_barang'];
    $jumlah = $_POST['jumlah'];
    $tanggal_keluar = $_POST['tanggal_keluar'];
    $penempatan = $_POST['penempatan'];
    $penerima = $_POST['penerima'];
    // $sub_total       = $_POST['sub_total'];


    // Jika user mengisi 00-00-0000, ubah ke NULL
    if ($tanggal_keluar == '0000-00-00' || $tanggal_keluar == '00-00-0000') {
        $tanggal_keluar = null;
    }

    // Validasi format tanggal
    if (!preg_match("/^\d{4}-\d{2}-\d{2}$/", $tanggal_keluar) || strtotime($tanggal_keluar) === false) {
        $response = ['response' => 'negative', 'alert' => 'Format tanggal tidak valid'];
    }

    if ($kd_transaksi == "" || $kd_pretransaksi == "" || $barang == "" || $jumlah == "" || $tanggal_keluar == "" || $penempatan == "" || $penerima == "") {
        $response = ['response' => 'negative', 'alert' => 'Lengkapi field'];
    } else {
        if ($jumlah < 1) {
            $response = ['response' => 'negative', 'alert' => 'Pemakaian barang minimal 1'];
        } else {
            $sisa = $trans->selectWhere("table_barang_hardware", "kd_barang", $barang);
            if ($sisa['stok_barang'] < $jumlah) {
                $response = ['response' => 'negative', 'alert' => 'Stok tersisa ' . $sisa['stok_barang']];
            } else {
                $value = "'$kd_pretransaksi','$kd_transaksi','$barang','$jumlah','$tanggal_keluar','$penempatan','$penerima','0'";

                // $response2 = $trans->update("table_barang_hardware", $jumlah, "kd_barang", $barang, "?page=viewPemakaianBarangHardware");
                // $response = $trans->insert($table,$value,"?page=viewPemakaianBarangHardware");

                // Kurangi stok
                $stok_sisa = $sisa['stok_barang'] - $jumlah;
                $trans->customQuery("UPDATE table_barang_hardware SET stok_barang = '$stok_sisa' WHERE kd_barang = '$barang'");

                // Simpan data pemakaian
                $response = $trans->insert($table, $value, "?page=viewPemakaianBarangHardware");


            }
        }
    }
}
if (isset($_GET['delete'])) {
    $id = $_GET['id'];
    $where = "kd_pretransaksi";
    $response = $trans->delete("table_pretransaksi", $where, $id, "?page=addPemakaianBarangHardware");
}
?>
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
                                    <i class="fas fa-server"></i>Form Pemakaian Barang
                                </h3>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="">Kode Pemakaian</label>
                                            <input style="font-weight: bold; color: #254744;" type="text"
                                                class="form-control" value="<?= $transkode; ?>" readonly
                                                name="kd_transaksi">
                                        </div>
                                        <div class="form-group">
                                            <label for="">Kode Antrian</label>
                                            <input style="font-weight: bold; color: #254744;" type="text"
                                                class="form-control" value="<?= $antrian; ?>" readonly
                                                name="kd_pretransaksi" id="antrian">
                                        </div>
                                        <div class="form-group">
                                            <label>Kode Barang</label>
                                            <div class="input-group">
                                                <input style="font-weight: bold; color: #254744;" type="text"
                                                    class="form-control" name="kd_barang" readonly
                                                    placeholder="Kode Barang" value="<?= @$dataR['kd_barang'] ?>">
                                                <div class="input-group-append">
                                                    <a class="btn btn-primary" href="#fajarmodal"
                                                        data-toggle="modal">Pilih Barang</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="">Nama Barang</label>
                                            <input type="text" class="form-control" name="nama_barang"
                                                placeholder="Nama Barang" value="<?php echo @$dataR['nama_barang']; ?>"
                                                readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="">Jumlah</label>
                                            <input type="number" class="form-control" placeholder="Input Jumlah"
                                                name="jumlah" value="" id="jumjum" min="0" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label for="tanggal_keluar">Tanggal Keluar</label>
                                            <input type="date" class="form-control" name="tanggal_keluar" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="">Penempatan</label>
                                            <div class="form-group">
                                                <select name="penempatan" class="form-control mb-1">
                                                    <option value="">Pilih Ruangan</option>
                                                    <optgroup label="Instalasi Gawat Darurat">
                                                        <option value="IGD">IGD</option>
                                                    </optgroup>
                                                    <optgroup label="Kamar Operasi">
                                                        <option value="CATHLAB">CATHLAB</option>
                                                        <option value="OK">OK</option>
                                                        <option value="VK">VK</option>
                                                    </optgroup>
                                                    <optgroup label="Kantor">
                                                        <option value="Ruangan Anggaran">Ruangan Anggaran</option>
                                                        <option value="Ruangan Bendahara">Ruangan Bendahara</option>
                                                        <option value="Ruangan Direktur">Ruangan Direktur</option>
                                                        <option value="Ruangan Kepegawaian">Ruangan Kepegawaian</option>
                                                        <option value="Ruangan Keperawatan">Ruangan Keperawatan</option>
                                                        <option value="Ruangan Pelayanan Medis">Ruangan Pelayanan Medis
                                                        </option>
                                                        <option value="Ruangan Penunjang">Ruangan Penunjang</option>
                                                        <option value="Ruangan Perlengkapan">Ruangan Perlengkapan
                                                        </option>
                                                        <option value="Ruangan Umum">Ruangan Umum</option>
                                                        <option value="Ruangan WADIR Keuangan">Ruangan Wakil Direktur
                                                            Keuangan</option>
                                                        <option value="Ruangan WADIR Pelayanan">Ruangan Wakil Direktur
                                                            Pelayanan</option>
                                                        <option value="Ruangan WADIR Umum & SDM"> Ruangan Wakil Direktur
                                                            Umum & SDM</option>
                                                    </optgroup>
                                                    <optgroup label="Penunjang">
                                                        <option value="Antrol">Antrian Online</option>
                                                        <option value="Apotik RI">Apotik Rawat Inap</option>
                                                        <option value="Apotik Rajal">Apotik Rawat Jalan</option>
                                                        <option value="Bank Darah">Bank Darah</option>
                                                        <option value="CSSD">CSSD</option>
                                                        <option value="Forensik">Forensik</option>
                                                        <option value="Gizi">Gizi</option>
                                                        <option value="HD">Hemodialisa</option>
                                                        <option value="IPSRS NM">IPSRS Non Medis</option>
                                                        <option value="IPSRS M">IPSRS Medis</option>
                                                        <option value="Kasir Central">Kasir Central</option>
                                                        <option value="KESLING">Kesehatan Lingkungan</option>
                                                        <option value="LAB PA">Labor PA</option>
                                                        <option value="LAB PK">Labor PK</option>
                                                        <option value="Mutu">Mutu</option>
                                                        <option value="PKRS">PKRS</option>
                                                        <option value="Laundry">Laundry</option>
                                                        <option value="Radiologi">Radiologi</option>
                                                        <option value="MR Adm">Rekam Medik Admission</option>
                                                        <option value="MR IGD">Rekam Medik IGD</option>
                                                        <option value="MR Central">Rekam Medik Central</option>
                                                        <option value="MR Coding">Rekam Medik Coding</option>
                                                        <option value="SIMRS">SIMRS</option>
                                                        <option value="SIPP">SIPP</option>
                                                    </optgroup>
                                                    <optgroup label="Poliklnik">
                                                        <option value="Poli Anak">Poli Anak</option>
                                                        <option value="Poli Bedah Digestif">Poli Bedah Digestif</option>
                                                        <option value="Poli Bedah Mulut">Poli Bedah Mulut</option>
                                                        <option value="Poli Bedah Umum">Poli Bedah Umum</option>
                                                        <option value="Poli Geriatri">Poli Geriatri</option>
                                                        <option value="Poli Gigi">Poli Gigi</option>
                                                        <option value="Poli Interne">Poli Interne</option>
                                                        <option value="Poli Jantung">Poli Jantung</option>
                                                        <option value="Poli Jiwa">Poli Jiwa</option>
                                                        <option value="Poli Kebidanan">Poli Kebidanan</option>
                                                        <option value="Poli Kulit dan Kelamin">Poli Kulit dan Kelamin
                                                        </option>
                                                        <option value="Poli Mata">Poli Mata</option>
                                                        <option value="Poli Neurologi">Poli Neurologi</option>
                                                        <option value="Poli Onkologi">Poli Onkologi</option>
                                                        <option value="Poli Ortopedi">Poli Ortopedi</option>
                                                        <option value="Poli Paru">Poli Paru</option>
                                                        <option value="Poli THT">Poli THT</option>
                                                        <option value="Rehabilitas Medik">Rehabilitas Medik</option>
                                                    </optgroup>
                                                    <optgroup label="Rawat Inap">
                                                        <option value="RI Anak">Rawat Inap Anak</option>
                                                        <option value="RI Bedah">Rawat Inap Bedah</option>
                                                        <option value="RI Interne">Rawat Inap Interne</option>
                                                        <option value="RI Jantung">Rawat Inap Jantung</option>
                                                        <option value="RI Jiwa">Rawat Inap Jiwa</option>
                                                        <option value="RI Kebidanan">Rawat Inap Kebidanan</option>
                                                        <option value="RI Mata">Rawat Inap Mata</option>
                                                        <option value="RI Neurologi">Rawat Inap Neurologi</option>
                                                        <option value="RI Paru">Rawat Inap Paru</option>
                                                        <option value="RI Perina">Rawat Inap Perina</option>
                                                        <option value="RI THT">Rawat Inap THT</option>
                                                    </optgroup>
                                                    <optgroup label="Unit Perawatan Intensif">
                                                        <option value="CVCU">CVCU</option>
                                                        <option value="HCU">HCU</option>
                                                        <option value="ICU">ICU</option>
                                                    </optgroup>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="">Penerima</label>
                                                <input type="text" class="form-control" name="penerima"
                                                    placeholder="Nama Penerima" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button name="btnAdd" class="btn btn-primary"><i class="fa fa-download"></i>
                                        Simpan</button>
                                    <button type="reset" class="btn btn-danger"><i class="fa fa-eraser"></i>
                                        Reset</button>
                                </div>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
</div>
</div>

<div class="modal fade" id="fajarmodal" tabindex="-1" role="dialog" aria-labelledby="staticModalLabel"
    aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Pilih Barang</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-hover table-bordered" id="sampleTable">
                    <thead>
                        <tr>
                            <td>Kode Barang</td>
                            <td>Nama Barang</td>
                            <td>Harga</td>
                            <td>Stok</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($barangs as $brs) { ?>
                            <tr>
                                <td><a
                                        href="pageAdmin.php?page=addPemakaianBarangHardware&getItem&id=<?php echo $brs['kd_barang'] ?>"><?php echo $brs['kd_barang'] ?></a>
                                </td>
                                <td><?php echo $brs['nama_barang'] ?></td>
                                <td><?php echo $brs['harga_barang'] ?></td>
                                <td><?php echo $brs['stok_barang'] ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="vendor/jquery-3.2.1.min.js"></script>
<script>
    $(document).ready(function () {


        $('#barang_nama').change(function () {
            var barang = $(this).val();
            $.ajax({
                type: "POST",
                url: 'ajaxTransaksi.php',
                data: { 'selectData': barang },
                success: function (data) {
                    $("#harba").val(data);
                    $("#jumjum").val();
                    var jum = $("#jumjum").val();
                    var kali = data * jum;
                    $("#totals").val(kali);
                }
            })
        });


        $('#jumjum').keyup(function () {
            var jumlah = $(this).val();
            var harba = $('#harba').val();
            var kali = harba * jumlah;
            $("#totals").val(kali);
        });

        $('#bayar').keyup(function () {
            var bayar = $(this).val();
            var total = $('#tot').val();
            var kembalian = bayar - total;
            $('#kem').val(kembalian);
        })
    })
</script>