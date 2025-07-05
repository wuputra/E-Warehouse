<?php
$qb = new lsp();
$dataB = $qb->select("detailbarang");
if ($_SESSION['level'] != "Network") {
	// header("location:../index.php");
}
?>
<div class="main-content" style="margin-top: 30px;">
	<div class="section__content section__content--p30">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12">
					<div class="card">
						<div class="card-header d-flex justify-content-between align-items-center">
							<h3>Stock Barang Jaringan</h3>
							<div>
								<a href="network/exportStockBarang.php" name="export" target="_blank"
									class="btn btn-success">
									<i class="fa fa-file-excel-o"></i> Export Excel
								</a>
								<a href="network/datastockbarangexcel.php" target="_blank" class="btn btn-primary">
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
										<th style="text-align: center;">Kode barang</th>
										<th style="text-align: center;">Nama barang</th>
										<th style="text-align: center;">Spesfikasi Barang</th>
										<th style="text-align: center;">Merek</th>
										<th style="text-align: center;">Distributor</th>
										<th style="text-align: center;">Tanggal Update</th>
										<th style="text-align: center;">Stock</th>
									</tr>
								</thead>
								<tbody>
									<?php
									$no = 1;
									foreach ($dataB as $ds) { ?>
										<tr>
											<td style="text-align: center;"><?= $ds['kd_barang'] ?></td>
											<td><?= $ds['nama_barang'] ?></td>
											<td style="text-align: justify">
												<?php
												$barang = $qb->selectWhere("table_barang", "kd_barang", $ds['kd_barang']);
												echo nl2br(htmlspecialchars($barang['spesifikasi']));
												?>
											</td>
											<td style="text-align: center;"><?= $ds['merek'] ?></td>
											<td style="text-align: center;"><?= $ds['nama_distributor'] ?></td>
											<td style="text-align: center;"><?= $ds['tanggal_masuk'] ?></td>
											<td style="text-align: center;"><?= $ds['stok_barang'] ?></td>
											<!-- <td class="text-center">
													<a href="?page=viewBarangDetail&id=<?php echo $ds['kd_barang'] ?>" class="btn btn-warning"><i class="fa fa-search"></i></a>
											</td> -->
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