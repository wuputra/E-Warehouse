<?php
$trans = new lsp();
if (isset($_GET['id'])) {
	$id = $_GET['id'];
	$dataEdit = $trans->selectWhere("table_pretransaksi_hardware", "kd_pretransaksi", $id);
	$dataR = $trans->selectWhere("table_barang_hardware", "kd_barang", $dataEdit['kd_barang']);

	$transkode = $dataEdit['kd_transaksi'];
	$antrian = $dataEdit['kd_pretransaksi'];
	$jumlah = $dataEdit['jumlah'];
	$penempatan = $dataEdit['penempatan'];
	$tanggal_keluar = $dataEdit['tanggal_keluar'];
	$penerima = $dataEdit['penerima'];
} else {
	$transkode = $trans->autokode("table_transaksi", "kd_transaksi", "KP");
	$antrian = $trans->autokode("table_pretransaksi", "kd_pretransaksi", "AN");
}
if (isset($_POST['btnUpdate'])) {
	$kd_pretransaksi = $_POST['kd_pretransaksi'];
	$kd_transaksi = $_POST['kd_transaksi'];
	$kd_barang = $_POST['kd_barang'];
	$jumlah = $_POST['jumlah'];
	$tanggal_keluar = $_POST['tanggal_keluar'];
	$penempatan = $_POST['penempatan'];
	$penerima = $_POST['penerima'];

	if (!preg_match("/^\d{4}-\d{2}-\d{2}$/", $tanggal_keluar) || strtotime($tanggal_keluar) === false) {
		$response = ['response' => 'negative', 'alert' => 'Format tanggal tidak valid'];
	} elseif ($kd_transaksi == "" || $kd_pretransaksi == "" || $kd_barang == "" || $jumlah == "" || $tanggal_keluar == "" || $penempatan == "" || $penerima == "") {
		$response = ['response' => 'negative', 'alert' => 'Lengkapi semua field'];
	} elseif ($jumlah < 1) {
		$response = ['response' => 'negative', 'alert' => 'Jumlah minimal 1'];
	} else {
		// Ambil stok barang sekarang
		$barangSekarang = $trans->selectWhere("table_barang_hardware", "kd_barang", $kd_barang);
		$stokSekarang = $barangSekarang['stok_barang'];

		// Ambil jumlah lama dari pretransaksi (yang sedang diedit)
		$dataLama = $trans->selectWhere("table_pretransaksi_hardware", "kd_pretransaksi", $kd_pretransaksi);
		$jumlahLama = $dataLama['jumlah'];

		// Hitung stok baru (stok ditambah jumlah lama, dikurangi jumlah baru)
		$stokBaru = $stokSekarang + $jumlahLama - $jumlah;

		if ($stokBaru < 0) {
			$response = ['response' => 'negative', 'alert' => 'Stok tidak mencukupi. Stok tersisa setelah edit akan menjadi negatif.'];
		} else {
			$value = "
			kd_transaksi='$kd_transaksi',
			kd_barang='$kd_barang',
			jumlah='$jumlah',
			tanggal_keluar='$tanggal_keluar',
			penempatan='$penempatan',
			penerima='$penerima'
		";
			$where = "kd_pretransaksi";
			$whereValues = $kd_pretransaksi;

			// Update data pretransaksi
			$response = $trans->update("table_pretransaksi_hardware", $value, $where, $whereValues, null);

			// Update stok barang hardware
			if ($response['response'] == 'positive') {
				$trans->update(
					"table_barang_hardware",
					"stok_barang='$stokBaru'",
					"kd_barang",
					$kd_barang,
					"?page=viewPemakaianBarangHardware"
				);
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
									<i class="fas fa-network-wired"></i>Form Edit Pemakaian Barang
								</h3>
							</div>
							<div class="row">
								<input type="hidden" name="kd_pretransaksi" value="<?= $antrian ?>">
								<div class="col-md-6">
									<div class="card-body">
										<div class="form-group">
											<label for="">Kode Antrian</label>
											<input style="font-weight: bold; color: #254744;" type="text"
												class="form-control" value="<?= $antrian; ?>" readonly
												name="kd_transaksi">
										</div>
										<div class="form-group">
											<label for="">Kode Barang</label>
											<input style="font-weight: bold; color: #254744;" type="text"
												class="form-control" name="kd_barang" value="<?= $dataR['kd_barang']; ?>" readonly
												name="kd_pretransaksi" id="antrian">
										</div>
										<div class="form-group">
											<label for="">Nama Barang</label>
											<input type="text" class="form-control" name="nama_barang"
												placeholder="Nama Barang" value="<?php echo @$dataR['nama_barang']; ?>"
												readonly>
										</div>
										<div class="form-group">
											<label>Ketersediaan Barang</label>
											<div class="input-group">
												<input type="text"
													class="form-control" name="stok" readonly
													placeholder="Kode Barang" value="<?= @$dataR['stok_barang'] ?>">
											</div>
										</div>

									</div>
								</div>
								<div class="col-md-6">
									<div class="card-body">
										<div class="form-group">
											<label for="">Jumlah</label>
											<input type="number" class="form-control"
												name="jumlah" id="jumjum" min="0" value="<?= $jumlah; ?>">
										</div>
										<div class="form-group">
											<label for="tanggal_keluar">Tanggal Keluar</label>
											<input
												type="date"
												class="form-control"
												name="tanggal_keluar"
												value="<?= isset($dataEdit['tanggal_keluar']) ? $dataEdit['tanggal_keluar'] : '' ?>">
										</div>

										<div class="form-group">
											<label for="penempatan">Penempatan</label>
											<div class="form-group">
												<select name="penempatan" id="penempatan" class="form-control mb-1">
													<option value="" disabled <?= empty($penempatan) ? 'selected' : '' ?>>Pilih Ruangan</option>

													<optgroup label="Instalasi Gawat Darurat">
														<option value="IGD" <?= $penempatan == 'IGD' ? 'selected' : '' ?>>IGD</option>
													</optgroup>

													<optgroup label="Kamar Operasi">
														<option value="CATHLAB" <?= $penempatan == 'CATHLAB' ? 'selected' : '' ?>>CATHLAB</option>
														<option value="OK" <?= $penempatan == 'OK' ? 'selected' : '' ?>>OK</option>
														<option value="VK" <?= $penempatan == 'VK' ? 'selected' : '' ?>>VK</option>
													</optgroup>

													<optgroup label="Kantor">
														<option value="Ruangan Anggaran" <?= $penempatan == 'Ruangan Anggaran' ? 'selected' : '' ?>>Ruangan Anggaran</option>
														<option value="Ruangan Bendahara" <?= $penempatan == 'Ruangan Bendahara' ? 'selected' : '' ?>>Ruangan Bendahara</option>
														<option value="Ruangan Direktur" <?= $penempatan == 'Ruangan Direktur' ? 'selected' : '' ?>>Ruangan Direktur</option>
														<option value="Ruangan Kepegawaian" <?= $penempatan == 'Ruangan Kepegawaian' ? 'selected' : '' ?>>Ruangan Kepegawaian</option>
														<option value="Ruangan Keperawatan" <?= $penempatan == 'Ruangan Keperawatan' ? 'selected' : '' ?>>Ruangan Keperawatan</option>
														<option value="Ruangan Pelayanan Medis" <?= $penempatan == 'Ruangan Pelayanan Medis' ? 'selected' : '' ?>>Ruangan Pelayanan Medis</option>
														<option value="Ruangan Penunjang" <?= $penempatan == 'Ruangan Penunjang' ? 'selected' : '' ?>>Ruangan Penunjang</option>
														<option value="Ruangan Perlengkapan" <?= $penempatan == 'Ruangan Perlengkapan' ? 'selected' : '' ?>>Ruangan Perlengkapan</option>
														<option value="Ruangan Umum" <?= $penempatan == 'Ruangan Umum' ? 'selected' : '' ?>>Ruangan Umum</option>
														<option value="Ruangan WADIR Keuangan" <?= $penempatan == 'Ruangan WADIR Keuangan' ? 'selected' : '' ?>>Ruangan Wakil Direktur Keuangan</option>
														<option value="Ruangan WADIR Pelayanan" <?= $penempatan == 'Ruangan WADIR Pelayanan' ? 'selected' : '' ?>>Ruangan Wakil Direktur Pelayanan</option>
														<option value="Ruangan Wadir Umum & SDM" <?= $penempatan == 'Ruangan Wadir Umum & SDM' ? 'selected' : '' ?>>Ruangan Wakil Direktur Umum & SDM</option>
													</optgroup>

													<optgroup label="Penunjang">
														<?php
														$penunjang = [
															"Antrol" => "Antrian Online",
															"Apotik RI" => "Apotik Rawat Inap",
															"Apotik Rajal" => "Apotik Rawat Jalan",
															"Bank Darah" => "Bank Darah",
															"CSSD" => "CSSD",
															"Forensik" => "Forensik",
															"Gizi" => "Gizi",
															"HD" => "Hemodialisa",
															"IPSRS NM" => "IPSRS Non Medis",
															"IPSRS M" => "IPSRS Medis",
															"Kasir Central" => "Kasir Central",
															"KESLING" => "Kesehatan Lingkungan",
															"LAB PA" => "Labor PA",
															"LAB PK" => "Labor PK",
															"Mutu" => "Mutu",
															"PKRS" => "PKRS",
															"Laundry" => "Laundry",
															"Radiologi" => "Radiologi",
															"MR Adm" => "Rekam Medik Admission",
															"MR IGD" => "Rekam Medik IGD",
															"MR Central" => "Rekam Medik Central",
															"MR Coding" => "Rekam Medik Coding",
															"SIMRS" => "SIMRS",
															"SIPP" => "SIPP"
														];
														foreach ($penunjang as $value => $label) {
															echo '<option value="' . $value . '" ' . ($penempatan == $value ? 'selected' : '') . '>' . $label . '</option>';
														}
														?>
													</optgroup>

													<optgroup label="Poliklnik">
														<?php
														$poli = [
															"Poli Anak",
															"Poli Bedah Digestif",
															"Poli Bedah Mulut",
															"Poli Bedah Umum",
															"Poli Geriatri",
															"Poli Gigi",
															"Poli Interne",
															"Poli Jantung",
															"Poli Jiwa",
															"Poli Kebidanan",
															"Poli Kulit dan Kelamin",
															"Poli Mata",
															"Poli Neurologi",
															"Poli Onkologi",
															"Poli Ortopedi",
															"Poli Paru",
															"Poli THT",
															"Rehabilitas Medik"
														];
														foreach ($poli as $value) {
															echo '<option value="' . $value . '" ' . ($penempatan == $value ? 'selected' : '') . '>' . $value . '</option>';
														}
														?>
													</optgroup>

													<optgroup label="Rawat Inap">
														<?php
														$ri = [
															"RI Anak",
															"RI Bedah",
															"RI Interne",
															"RI Jantung",
															"RI Jiwa",
															"RI Kebidanan",
															"RI Mata",
															"RI Neurologi",
															"RI Paru",
															"RI Perina",
															"RI THT"
														];
														foreach ($ri as $value) {
															echo '<option value="' . $value . '" ' . ($penempatan == $value ? 'selected' : '') . '>' . str_replace("RI", "Rawat Inap", $value) . '</option>';
														}
														?>
													</optgroup>

													<optgroup label="Unit Perawatan Intensif">
														<?php
														$unit = ["CVCU", "HCU", "ICU"];
														foreach ($unit as $value) {
															echo '<option value="' . $value . '" ' . ($penempatan == $value ? 'selected' : '') . '>' . $value . '</option>';
														}
														?>
													</optgroup>
												</select>
											</div>
										</div>

										<div class="form-group">
											<label for="">Penerima</label>
											<input type="text" class="form-control" name="penerima"
												placeholder="Nama Penerima" value="<?= $penerima; ?>">
										</div>
									</div>
								</div>
							</div>
							<div class="card-footer">
								<button name="btnUpdate" class="btn btn-primary"><i class="fa fa-download"></i>
									Update</button>

								<a href="?page=viewPemakaianBarangHardware" class="btn btn-danger"><i class="fa fa-repeat"></i>
									Kembali</a>
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
										href="pageHardware.php?page=addPemakaianBarang&getItem&id=<?php echo $brs['kd_barang'] ?>"><?php echo $brs['kd_barang'] ?></a>
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
	$(document).ready(function() {


		$('#barang_nama').change(function() {
			var barang = $(this).val();
			$.ajax({
				type: "POST",
				url: 'ajaxTransaksi.php',
				data: {
					'selectData': barang
				},
				success: function(data) {
					$("#harba").val(data);
					$("#jumjum").val();
					var jum = $("#jumjum").val();
					var kali = data * jum;
					$("#totals").val(kali);
				}
			})
		});


		$('#jumjum').keyup(function() {
			var jumlah = $(this).val();
			var harba = $('#harba').val();
			var kali = harba * jumlah;
			$("#totals").val(kali);
		});

		$('#bayar').keyup(function() {
			var bayar = $(this).val();
			var total = $('#tot').val();
			var kembalian = bayar - total;
			$('#kem').val(kembalian);
		})
	})
</script>