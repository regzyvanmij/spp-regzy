<?php
include 'koneksi.php';
if (empty($_SESSION['petugas'])) {
	header('location: login.php');
}

if (isset($_POST['pembayaran'])) {
	$id_petugas = $_SESSION['petugas']['id_petugas'];
	$nisn = $_POST['nisn'];
	$tgl_bayar = $_POST['tgl_bayar'];
	$id_spp = $_POST['id_spp'];
	$jumlah_bayar = $_POST['jumlah_bayar'];

	$cektransaksi = mysqli_query($koneksi, "SELECT * FROM pembayaran WHERE nisn='$nisn' AND id_spp='$id_spp'");
	$spp = mysqli_query($koneksi, "SELECT * FROM spp WHERE id_spp='$id_spp'");
	$data = mysqli_fetch_array($spp);

	if (mysqli_num_rows($cektransaksi) > 0) {
		echo '<script>alert("siswa ini telah melakukan transaksi untuk spp ini");location.href="?page=laporan";</script>';
	} elseif ($jumlah_bayar > $data['nominal']) {
		echo '<script>alert("jumlah bayar melebihi kekurangan");location.href="?page=laporan";</script>';
	} else {
		$query = mysqli_query($koneksi, "INSERT INTO pembayaran (id_petugas,nisn,tgl_bayar,id_spp,jumlah_bayar) VALUES('$id_petugas','$nisn','$tgl_bayar','$id_spp','$jumlah_bayar')");
		if ($query) {
			echo '<script>alert("pembayaran berhasil di tambah");location.href="?page=laporan";</script>';
		}
	}
}


?>



<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="Responsive Admin &amp; Dashboard Template based on Bootstrap 5">
	<meta name="author" content="AdminKit">
	<meta name="keywords" content="adminkit, bootstrap, bootstrap 5, admin, dashboard, template, responsive, css, sass, html, theme, front-end, ui kit, web">

	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link rel="shortcut icon" href="img/icons/icon-48x48.png" />

	<link rel="canonical" href="https://demo-basic.adminkit.io/" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha512-MoRNloxbStBcD8z3M/2BmnT+rg4IsMxPkXaGh2zD6LGNNFE80W3onsAhRcMAMrSoyWL9xD7Ert0men7vR8LUZg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

	<title>pembayaran spp
		<?php
		$page = isset($_GET['page']) ? $_GET['page'] : '';
		$cek = preg_replace('/-/', ' ', $page);
		$title = ucwords($cek);
		echo $title;
		?>
	</title>

	<script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="//cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
	<script src="//cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

	<link href="css/app.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
</head>

<body>
	<div class="wrapper">
		<nav id="sidebar" class="sidebar js-sidebar">
			<div class="sidebar-content js-simplebar">
				<a class="sidebar-brand" href="index.html">
					<span class="align-middle">Admin spp</span>
				</a>


				<?php
				if (!empty($_SESSION['petugas']['level']) && !empty($_SESSION['petugas']['level'] == 'admin')) {
				?>
					<ul class="sidebar-nav">
						<li class="sidebar-header"></li>
						<li class="sidebar-item 
					<?php
					if (empty($_GET['page'])) {
						echo 'active';
					}
					?>
					">
							<a class="sidebar-link" href="index.php">
								<i class="align-middle" data-feather="sliders"></i> <span class="align-middle">Dashboard Pembayaran</span>
							</a>
						</li>

						<li class="sidebar-item 
					<?php
					if ($page == 'kelas' || $page == 'tambah-kelas' || $page == 'edit-kelas') {
						echo 'active';
					}
					?>
					">
							<a class="sidebar-link" href="?page=kelas">
								<i class="align-middle" data-feather="book-open"></i> <span class="align-middle">Kelas</span>
							</a>
						</li>

						<li class="sidebar-item
					<?php
					if ($page == 'siswa' || $page == 'tambah-siswa' || $page == 'edit-siswa') {
						echo 'active';
					}
					?>
					
					">
							<a class="sidebar-link" href="?page=siswa">
								<i class="align-middle" data-feather="users"></i> <span class="align-middle">Siswa</span>
							</a>
						</li>

						<li class="sidebar-item
					<?php
					if ($page == 'petugas'  || $page == 'tambah-petugas' || $page == 'edit-petugas') {
						echo 'active';
					}
					?>
					">
							<a class="sidebar-link" href="?page=petugas">
								<i class="align-middle" data-feather="user-plus"></i> <span class="align-middle">Petugas</span>
							</a>
						</li>

						<li class="sidebar-item
					<?php
					if ($page == 'spp'  || $page == 'tambah-spp' || $page == 'edit-spp') {
						echo 'active';
					}
					?>
					">
							<a class="sidebar-link" href="?page=spp">
								<i class="align-middle" data-feather="book"></i> <span class="align-middle">SPP</span>
							</a>
						</li>

						<li class="sidebar-item
					<?php
					if ($page == 'laporan') {
						echo 'active';
					}
					?>
					">
							<a class="sidebar-link" href="?page=laporan">
								<i class="align-middle" data-feather="bar-chart"></i> <span class="align-middle">Laporan</span>

							</a>
						</li>
					</ul>
					<div class="sidebar-cta">
						<div class="sidebar-cta-content">
							<div class="d-grid">
								<button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahpembayaran">+ Tambah Transaksi</button>
							</div>
						</div>
					</div>
					<?php
				} else {
					if (!empty($_SESSION['petugas']['level']) && !empty($_SESSION['petugas']['level'] == 'petugas')) {
					?>
						<ul class="sidebar-nav">
							<li class="sidebar-header"></li>
							<li class="sidebar-item 
					<?php
						if (empty($_GET['page'])) {
							echo 'active';
						}
					?>
					">
								<a class="sidebar-link" href="index.php">
									<i class="align-middle" data-feather="sliders"></i> <span class="align-middle">Dashboard Pembayaran</span>
								</a>
							</li>

							<li class="sidebar-item
					<?php
						if ($page == 'siswa' || $page == 'tambah-siswa' || $page == 'edit-siswa') {
							echo 'active';
						}
					?>
					
					">
								<a class="sidebar-link" href="?page=siswa">
									<i class="align-middle" data-feather="users"></i> <span class="align-middle">Siswa</span>
								</a>
							</li>

							<li class="sidebar-item
					<?php
						if ($page == 'laporan') {
							echo 'active';
						}
					?>
					">
								<a class="sidebar-link" href="?page=laporan">
									<i class="align-middle" data-feather="bar-chart"></i> <span class="align-middle">Laporan</span>

								</a>
							</li>
							<div class="sidebar-cta">
								<div class="sidebar-cta-content">
									<div class="d-grid">
										<button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahpembayaran">+ Tambah Transaksi</button>
									</div>
								</div>
							</div>


						<?php
					} else {
						?>
							<ul class="sidebar-nav">
								<li class="sidebar-header"></li>
								<li class="sidebar-item 
					<?php
						if (empty($_GET['page'])) {
							echo 'active';
						}
					?>
					">
									<a class="sidebar-link" href="index.php">
										<i class="align-middle" data-feather="sliders"></i> <span class="align-middle">Dashboard Pembayaran</span>
									</a>
								</li>
							</ul>

					<?php
					}
				}
					?>

			</div>
		</nav>

		<div class="main">
			<nav class="navbar navbar-expand navbar-light navbar-bg">
				<a class="sidebar-toggle js-sidebar-toggle">
					<i class="hamburger align-self-center"></i>
				</a>

				<div class="navbar-collapse collapse">
					<ul class="navbar-nav navbar-align">

						<li class="nav-item dropdown">
							<a class="nav-icon dropdown-toggle d-inline-block d-sm-none" href="#" data-bs-toggle="dropdown">
								<i class="align-middle" data-feather="settings"></i>
							</a>

							<a class="nav-link dropdown-toggle d-none d-sm-inline-block" href="#" data-bs-toggle="dropdown">
								<span class="text-dark">
									<?php
									if (!empty($_SESSION['petugas']['level'])) {
										echo $_SESSION['petugas']['nama_petugas'];
									} else {
										echo $_SESSION['petugas']['nama'];
									}
									?>
								</span>
							</a>
							<div class="dropdown-menu dropdown-menu-end">
								<a class="dropdown-item" href="logout.php">Log out</a>
							</div>
						</li>
					</ul>
				</div>
			</nav>

			<main class="content">
				<div class="container-fluid p-0">

					<?php
					$page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';
					include $page . '.php';
					?>


				</div>
			</main>

			<footer class="footer">
				<div class="container-fluid">
					<div class="row text-muted">
						<div class="col-6 text-start">
							<p class="mb-0">
								<a class="text-muted" href="https://www.instagram.com/refzyvanmij/" target="_blank"><strong>ReFZyVanMij</strong></a>
							<div class="col-6 text-end">
								<ul class="list-inline">
									<li class="list-inline-item">
										<a class="text-muted" href="https://www.google.com/" target="_blank">bantuan</a>
									</li>
									<li class="list-inline-item">
										<a class="text-muted" href="https://www.instagram.com/jokowi/?hl=en" target="_blank">hubungi</a>
									</li>
									<li class="list-inline-item">
										<a class="text-muted" href="https://www.instagram.com/jadihacker.id/?hl=en" target="_blank">Privacy</a>
									</li>
									<li class="list-inline-item">
										<a class="text-muted" href="https://adminkit.io/" target="_blank">Terms</a>
									</li>
								</ul>
							</div>
						</div>
					</div>
			</footer>
		</div>
	</div>

	<script src="js/app.js"></script>


	<div class="modal fade" id="tambahpembayaran" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="staticBackdropLabel">tambah pembayaran</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<form action="" method="post">
					<div class="modal-body">
						<div class="mb-3">
							<label class="form-label">Nama siswa</label>
							<select name="nisn" class="form-select">
								<?php
								$query = mysqli_query($koneksi, "SELECT * FROM siswa");
								while ($data = mysqli_fetch_array($query)) {
								?>
									<option value="<?php echo $data['nisn'] ?>"><?php echo $data['nama'] ?> </option>
								<?php

								}
								?>
							</select>
						</div>
						<input type="hidden" name="tgl_bayar" class="form-control" value="<?php echo date('Y-m-d') ?>">
						<div class="mb-3">
							<label class="form-label">pilih spp</label>
							<select name="id_spp" class="form-select">
								<?php
								$query = mysqli_query($koneksi, "SELECT * FROM spp");
								while ($data = mysqli_fetch_array($query)) {
								?>
									<option value="<?php echo $data['id_spp'] ?>"><?php echo $data['tahun'] ?> - <?php echo $data['nominal'] ?></option>
								<?php

								}
								?>
							</select>

						</div>
						<div class="mb-3">
							<label class="form-label">jumlah bayar</label>
							<input type="text" name="jumlah_bayar" class="form-control" required>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
						<button type="submit" class="btn btn-primary" name="pembayaran">simpan</button>
					</div>
				</form>
			</div>
		</div>
	</div>

</body>

</html>