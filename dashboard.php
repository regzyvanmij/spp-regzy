<?php
if (!empty($_SESSION['petugas']['level'])) {
?>
	<h1 class="h3 mb-3"><strong></strong> Dashboard</h1>

	<div class="row">
		<div class="col-12">
			<div class="w-100">
				<div class="row">
					<div class="col-sm-3">
						<div class="card">
							<div class="card-body">
								<div class="row">
									<div class="col mt-0">
										<h5 class="card-title">Jumlah kelas</h5>
									</div>

									<div class="col-auto">
										<div class="stat text-primary">
											<i class="align-middle" data-feather="book-open"></i>
										</div>
									</div>
								</div>
								<h1 class="mt-1 mb-3">
									<?php
									$query = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM kelas");
									$data = mysqli_fetch_array($query);
									echo $data['total'];

									?>
								</h1>

							</div>
						</div>
					</div>
					<div class="col-sm-3">
						<div class="card">
							<div class="card-body">
								<div class="row">
									<div class="col mt-0">
										<h5 class="card-title">Jumlah petugas</h5>
									</div>

									<div class="col-auto">
										<div class="stat text-primary">
											<i class="align-middle" data-feather="user"></i>
										</div>
									</div>
								</div>
								<h1 class="mt-1 mb-3">
									<?php
									$query = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM petugas");
									$data = mysqli_fetch_array($query);
									echo $data['total'];

									?>
								</h1>

							</div>
						</div>
					</div>
					<div class="col-sm-3">
						<div class="card">
							<div class="card-body">
								<div class="row">
									<div class="col mt-0">
										<h5 class="card-title">Jumlah siswa laki-laki&perempuan</h5>
									</div>

									<div class="col-auto">
										<div class="stat text-primary">
											<i class="align-middle" data-feather="users"></i>
										</div>
									</div>
								</div>
								<h1 class="mt-1 mb-3">
									<?php
									$query = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM siswa");
									$data = mysqli_fetch_array($query);
									echo $data['total'];

									?>
								</h1>

							</div>
						</div>
					</div>

					<div class="col-sm-3">
						<div class="card">
							<div class="card-body">
								<div class="row">
									<div class="col mt-0">
										<h5 class="card-title">Jumlah pembayaran</h5>
									</div>

									<div class="col-auto">
										<div class="stat text-primary">
											<i class="align-middle" data-feather="dollar-sign"></i>
										</div>
									</div>
								</div>
								<h1 class="mt-1 mb-3">
									<?php
									$query = mysqli_query($koneksi, "SELECT SUM(jumlah_bayar) AS total FROM pembayaran");
									$sum = mysqli_fetch_array($query);
									echo 'Rp ' . number_format($sum['total'], 2, ",", ".");
									?>
								</h1>

							</div>
						</div>
					</div>

				</div>
			</div>
		</div>


	</div>

<?php
} else {
?>
	<h1 class="h3 mb-3"><strong></strong>history</h1>
	<div class="row">
		<div class="col-12">
			<div class="card flex-fill">

				<div class="card-body">


					<table class=" table table-bordered table-striped table-hover cell-border" id="history">
						<thead>
							<tr>
								<th>Nama petugas</th>
								<th>Nama siswa</th>
								<th>tanggal bayar</th>
								<th>spp</th>
								<th>jumlah bayar</th>
								<th>status</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$id = $_SESSION['petugas']['nisn'];
							$query = mysqli_query($koneksi, "SELECT * FROM pembayaran INNER JOIN petugas ON pembayaran.id_petugas=petugas.id_petugas INNER JOIN siswa ON pembayaran.nisn=siswa.nisn INNER JOIN spp ON pembayaran.id_spp=spp.id_spp where pembayaran.nisn='$id' ");

							while ($data = mysqli_fetch_array($query)) {
							?>
								<tr>
									<td><?php echo $data['nama_petugas'] ?></td>
									<td><?php echo $data['nama'] ?></td>
									<td><?php echo date('d-m-y', strtotime($data['tgl_bayar'])) ?></td>
									<td><?php echo $data['tahun'] ?> - Rp. <?php echo number_format($data['nominal'], 2, ', ', '.') ?></td>
									<td>Rp. <?php echo number_format($data['jumlah_bayar'], 2, ', ', '.') ?></td>
									<td>
										<?php
										if ($data['jumlah_bayar'] < $data['nominal']) {
											echo 'kurang';
										} else {
											echo 'lunas';
										}
										?>
									</td>
								</tr>
							<?php
							}
							?>
						</tbody>
					</table>

				</div>
			</div>
		</div>
	</div>


	<script>
		let table = new DataTable('#history');
	</script>
<?php
}
?>