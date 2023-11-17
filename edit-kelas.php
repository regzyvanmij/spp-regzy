<?php
if (empty($_SESSION['petugas']['level'] == 'admin')) {
?>
    <script>
        alert('Akses di Tolak.');
        window.history.back();
    </script>
<?php
} else {
    $id = $_GET['id'];
    if (isset($_POST['nama_kelas'])) {
        $nama_kelas = $_POST['nama_kelas'];
        $kompetensi_keahlian = $_POST['kompetensi_keahlian'];
        $query = mysqli_query($koneksi, "UPDATE kelas SET nama_kelas = '$nama_kelas',kompetensi_keahlian='$kompetensi_keahlian' WHERE id_kelas='$id'");
        if ($query) {
            echo '<script>alert("Data berhasil di Update");location.href="?page=kelas";</script>';
        }
    }
    $query = mysqli_query($koneksi, "SELECT * FROM kelas WHERE id_kelas='$id'");
    $data = mysqli_fetch_array($query);

?>
    <h3 class="h3 mb-3"><strong></strong>Edit Kelas</h3>
    <div class="row">
        <div class="col-12">
            <div class="card flex-fill">

                <div class="card-body">
                    <form action="" method="post">
                        <div class="mb-3">
                            <label class="form-label">Nama Kelas</label>
                            <div>
                                <input type="text" name="nama_kelas" class="form-control" value="<?php echo $data['nama_kelas'] ?>" required>
                            </div>

                        </div>

                        <div class="mb-3">
                            <label class="form-label">kompetensi keahlian</label>
                            <input type="text" name="kompetensi_keahlian" class="form-control" value="<?php echo $data['kompetensi_keahlian'] ?>" required>

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
<?php
}
?>