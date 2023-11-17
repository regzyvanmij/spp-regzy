<?php
if (isset($_POST['nama_kelas'])) {
    $nama_kelas = $_POST['nama_kelas'];
    $kompetensi_keahlian = $_POST['kompetensi_keahlian'];
    $query = mysqli_query($koneksi, "INSERT INTO kelas (nama_kelas,kompetensi_keahlian) VALUES('$nama_kelas','$kompetensi_keahlian')");
    if ($query) {
        echo '<script>alert("Data berhasil di Tambah");location.href="?page=kelas";</script>';
    }
}
if (empty($_SESSION['petugas']['level'] == 'admin')) {
    ?>
        <script>
            alert('Akses di Tolak.');
            window.history.back();
        </script>
    <?php
}
?>

<h3 class="h3 mb-3"><strong></strong>Tambah Kelas</h3>
<div class="row">
    <div class="col-12">
        <div class="card flex-fill">

            <div class="card-body">
                <form action="" method="POST">
                    <div class="mb-3">
                        <label class="form-label">Nama Kelas</label>
                        <input type="text" name="nama_kelas" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">kompetensi keahlian</label>
                        <input type="text" name="kompetensi_keahlian" class="form-control" required>
                    </div>
                    <div class="mb-3" style="float:right;">
                        <button class="btn btn-primary">Simpan</button>
                        <button type="reset" class="btn btn-danger">reset</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>