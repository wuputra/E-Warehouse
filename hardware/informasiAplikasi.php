<?php
if ($_SESSION['level'] != "Admin") {
    // header("location:../index.php");
}
?>
<!-- Font Poppins -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

<div class="main-content" style="margin-top: 30px; font-family: 'Poppins', sans-serif;">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-10">
                    <div class="card shadow-sm">
                        <div class="card-header text-center bg-white border-bottom">
                            <h3 class="mb-1 text-dark">Informasi Penggunaan Aplikasi</h3>
                            <p>E-Warehouse SIMRS RSUD Mohammad Natsir</p>
                        </div>
                        <div class="card-body" style="font-size: 16px; color: #343a40;">
                            <table style="width: 100%; font-size: 16px; margin-bottom: 1rem;">
                                <tr>
                                    <td style="width: 180px;"><strong>Nama Aplikasi</strong></td>
                                    <td style="width: 10px;">:</td>
                                    <td>E-Warehouse SIMRS RSUD Mohammad Natsir</td>
                                </tr>
                                <tr>
                                    <td><strong>Tipe Aplikasi</strong></td>
                                    <td>:</td>
                                    <td>Web-based Inventory Management</td>
                                </tr>
                                <tr>
                                    <td><strong>Dibuat oleh</strong></td>
                                    <td>:</td>
                                    <td>Team SIMRS RSUD Mohammad Natsir</td>
                                </tr>
                                <tr>
                                    <td><strong>Tanggal Rilis</strong></td>
                                    <td>:</td>
                                    <td>07 Juli 2025</td>
                                </tr>
                            </table>
                            <strong>Desksripsi</strong>
                            <div style="text-align:justify">
                                E-Warehouse SIMRS merupakan aplikasi berbasis web yang dirancang untuk mengelola seluruh
                                aktivitas logistik barang SIMRS di lingkungan RSUD Mohammad Natsir. Aplikasi ini
                                dirancang untuk mempermudah proses pencatatan, pemantauan, dan pelaporan stock barang
                                jaringan dan hardware secara terstruktur dan real-time. Memungkinkan
                                pengguna untuk mengelola data barang, melakukan perpindahan keluar masuk barang, serta
                                mencetak kartu pemakaian dan laporan stock dengan cepat dan akurat.

                                Dengan antarmuka yang sederhana namun fungsional, sistem ini membantu petugas IT
                                dalam meminimalisir kesalahan pencatatan manual, meningkatkan efisiensi distribusi
                                barang, serta mendukung pengambilan keputusan manajerial berdasarkan data yang tersaji
                                secara sistematis.
                            </div><br>

                            <strong>Petunjuk Penggunaan</strong>
                            <ul style="padding-left: 25px;">
                                <li>Login ke sistem menggunakan akun yang terdaftar</li>
                                <li>Navigasikan ke menu sesuai kebutuhan: Barang, Pemakaian, Laporan</li>
                                <li>Gunakan tombol <strong>Print</strong> untuk mencetak laporan atau kartu barang</li>
                                <li>Gunakan <strong>Export</strong> untuk menyimpan laporan</li>
                                <li>Tekan tombol <strong>Logout</strong> setelah aplikasi selesai digunakan</li>
                            </ul>
                            <div class="d-flex justify-content-end mt-4">
                                <a href="?page" class="btn btn-danger ds">
									<i class="fa fa-repeat"></i> Kembali
								</a>
                            </div>
                        </div> <!-- end card-body -->
                    </div> <!-- end card -->
                </div> <!-- end col -->
            </div> <!-- end row -->
        </div> <!-- end container -->
    </div>
</div>