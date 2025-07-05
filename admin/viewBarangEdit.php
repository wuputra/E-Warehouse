<?php
$br = new lsp();
if ($_SESSION['level'] != "Admin") {
	header("location:../index.php");
}
$table = "table_barang";
$data = $br->selectWhere($table, "kd_barang", $_GET['id']);
$getMerek = $br->select("table_merek");
$getDistr = $br->select("table_distributor");
$waktu = date("Y-m-d");
if (isset($_POST['getSimpan'])) {
	$kode_barang = $br->validateHtml($_POST['kode_barang']);
	$nama_barang = $br->validateHtml($_POST['nama_barang']);
	$merek_barang = $br->validateHtml($_POST['merek_barang']);
	$distributor = $br->validateHtml($_POST['distributor']);
	$harga = $br->validateHtml($_POST['harga']);
	$spesfikasi = $br->validateHtml($_POST['spesifikasi']);
	$ket = $_POST['ket'];

	$stok_baru = $br->validateHtml($_POST['stok']);
	$stok_lama = $data['stok_barang']; // dari database sebelumnya
	$stok = $stok_lama + $stok_baru; // jumlahkan stok baru ke stok lama

	if (!is_numeric($stok_baru) || $stok_baru < 0) {
		$response = ['response' => 'negative', 'alert' => 'stok harus angka dan tidak boleh negatif'];
	}

	if ($kode_barang == " " || $nama_barang == " " || $merek_barang == " " || $distributor == " " || $harga == " " || $stok == " " || $spesfikasi == " " || $ket == " ") {
		$response = ['response' => 'negative', 'alert' => 'lengkapi field'];
	} else {
		if ($harga < 0 || $stok < 0) {
			$response = ['response' => 'negative', 'alert' => 'Harga atau stok tidak boleh minus'];
		} else {
			if ($_FILES['foto']['name'] == "") {
				$value = "kd_barang='$kode_barang',nama_barang='$nama_barang',kd_merek='$merek_barang',kd_distributor='$distributor',tanggal_masuk='$waktu',harga_barang='$harga',stok_barang='$stok',spesifikasi='$spesfikasi',keterangan='$ket'";
				$response = $br->update($table, $value, "kd_barang", $_GET['id'], "?page=viewBarang");
			} else {
				$response = $br->validateImage();
				if ($response['types'] == "true") {
					$value = "kd_barang='$kode_barang',nama_barang='$nama_barang',kd_merek='$merek_barang',kd_distributor='$distributor',tanggal_masuk='$waktu',harga_barang='$harga',stok_barang='$stok',spesifikasi='$spesfikasi',keterangan='$ket',gambar='$response[image]'";
					$response = $br->update($table, $value, "kd_barang", $_GET['id'], "?page=viewBarang");
				} else {
					$response = ['response' => 'negative', 'alert' => 'Gambar Error'];
				}
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
									<i class="fas fa-network-wired"></i>Edit Data Barang
								</h3>
							</div>
							<div class="card-body">
								<div class="col-12">
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label for="">Kode Barang</label>
												<input style="font-weight: bold; color: #254744;" type="text"
													class="form-control" name="kode_barang"
													value="<?php echo $data['kd_barang']; ?>" readonly>
											</div>
											<div class="form-group">
												<label for="">Nama Barang</label>
												<input type="text" class="form-control" name="nama_barang"
													value="<?php echo @$data['nama_barang'] ?>">
											</div>
											<div class="form-group">
												<label for="">Merek</label>
												<select name="merek_barang" class="form-control">
													<option value=" ">Pilih Merek</option>
													<?php foreach ($getMerek as $mr) { ?>
														<?php if ($mr['kd_merek'] == $data['kd_merek']) { ?>
															<option value="<?= $mr['kd_merek'] ?>" selected><?= $mr['merek'] ?>
															</option>
														<?php } else { ?>
															<option value="<?= $mr['kd_merek'] ?>"><?= $mr['merek'] ?></option>
														<?php } ?>
													<?php } ?>
												</select>
											</div>
											<div class="form-group">
												<label for="">Distributor</label>
												<select name="distributor" class="form-control">
													<option value=" ">Pilih distributor</option>
													<?php foreach ($getDistr as $dr) { ?>
														<?php if ($dr['kd_distributor'] == $data['kd_distributor']) { ?>
															<option value="<?= $dr['kd_distributor'] ?>" selected>
																<?= $dr['nama_distributor'] ?></option>
														<?php } else { ?>
															<option value="<?= $dr['kd_distributor'] ?>">
																<?= $dr['nama_distributor'] ?></option>
														<?php } ?>
													<?php } ?>
												</select>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label for="">Harga Barang</label>
												<input type="number" class="form-control" name="harga"
													value="<?php echo $data['harga_barang'] ?>">
											</div>
											<div class="form-group">
												<label for="">Stock Barang Sekarang</label>
												<input style="font-weight: bold; color: #254744;" type="text"
													class="form-control" name=""
													value="<?php echo $data['stok_barang'];
													if ($data['stok_barang'] < 1) {
														echo ' (Stock habis)';
													} else {
														echo ' (Stock tersedia)';
													} ?>"
													readonly>
											</div>
											<div class="form-group">
												<label for="">Restock Barang</label>
												<input placeholder="Tambah stock barang" type="number"
													class="form-control" name="stok" value="0" required>
											</div>
											<div class="form-group" id="fotoF">
												<label for="">Foto</label>
												<div class="row">
													<div class="col-6">
														<input type="file" name="foto" id="gambar"
															class="form-control-file">
													</div>
													<div class="col-6">
														<div>
															<img style="margin-top: -20px;" alt=""
																src="img/<?= $data['gambar'] ?>" width="120"
																class="img-responsive" id="pict">
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="col-md-12">
											<div class="form-group">
												<label for="">Spesifikasi Barang</label>
												<textarea name="spesifikasi" id="spesifikasi" class="form-control"
													rows="5" placeholder=""><?php echo $data['spesifikasi'] ?></textarea>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="card-footer">
								<button name="getSimpan" class="btn btn-primary"><i class="fa fa-download"></i>
									Update</button>
								<a href="?page=viewBarang" class="btn btn-danger"><i class="fa fa-repeat"></i>
									Kembali</a>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>