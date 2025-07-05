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
	// header("location:../index.php");
}
?>
<div class="main-content" style="margin-top: 30px;">
	<div class="section__content section__content--p30">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12">
					<div class="card">
						<div class="card">
							<div class="card-header d-flex justify-content-between align-items-center">
								<h3>Report Barang Hardware Terpakai</h3>
								<div>
									<a href="hardware/exportBarangHardwareTerpakai.php" name="export" target="_blank"
										class="btn btn-success">
										<i class="fa fa-file-excel-o"></i> Export Excel
									</a>
									<a href="hardware/databaranghardwareterpakaiexcel.php" target="_blank"
										class="btn btn-primary">
										<i class="fa fa-print"></i> Print
									</a>
									<a href="javascript:history.back()" class="btn btn-danger ds">
										<i class="fa fa-repeat"></i> Kembali
									</a>
								</div>
							</div>
							<div class="card-body">
								<table class="table table-hover table-bordered" id="sampleTable">
									<thead>
										<tr>
											<th style="text-align: center;">Kode Antrian</th>
											<th style="text-align: center;">Kode Barang</th>
											<th style="text-align: center;">Nama Barang</th>
											<th style="text-align: center;">Spesifikasi Barang</th>
											<th style="text-align: center;">Jumlah</th>
											<th style="text-align: center;">Tanggal Keluar</th>
											<th style="text-align: center;">Penempatan</th>
											<th style="text-align: center;">Penerima</th>
											<th style="text-align: center;">Kartu</th>
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
												<td style="text-align: justify">
													<?php
													$barang = $qb->selectWhere("table_barang_hardware", "kd_barang", $ds['kd_barang']);
													echo nl2br(htmlspecialchars($barang['spesifikasi']));
													?>
												</td>
												<td style="text-align: center;"><?= $ds['jumlah'] ?></td>
												<td style="text-align: center;"><?= $ds['tanggal_keluar'] ?></td>
												<td><?= $ds['penempatan'] ?></td>
												<td><?= $ds['penerima'] ?></td>
												<td style="text-align: center;">
												<a href="pageHardware.php?page=kartuPemakaianBarangHardware&id=<?= $ds['kd_pretransaksi'] ?>"
													class="btn btn-warning">
													<i class="fa fa-search"></i> Lihat
												</a>
											</td>
											</tr>
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