<?php
if (empty($_SESSION['petugas']['level'] == 'admin')) {
?>
    <script>
        alert('Akses di Tolak.');
        window.history.back();
    </script>
<?php
}
?>

<h1 class="h3 mb-3"><strong></strong>Kelas</h1>
<div class="row">
    <div class="col-12">
        <div class="card flex-fill">
            <div class="card-header">
                <a href="?page=tambah-kelas" class="btn btn-success btn-sm">+Tambah Kelas</a>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped table-hover cell-border" id="kelas">
                    <thead>
                        <tr>
                            <th>no kelas</th>
                            <th>Nama Kelas</th>
                            <th>kompetnsi kehlian</th>
                            <th>action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        $query = mysqli_query($koneksi, "SELECT * FROM kelas ");
                        while ($data = mysqli_fetch_array($query)) {
                        ?>
                            <tr>
                                <td><?php echo $no++ ?> </td>
                                <td><?php echo $data['nama_kelas'] ?></td>
                                <td><?php echo $data['kompetensi_keahlian'] ?></td>
                                <td>
                                    <a href="?page=edit-kelas&id=<?php echo $data['id_kelas'] ?>" class="btn btn-warning btn-sm">EDIT</a>
                                    <a href="?page=hapus-kelas&id=<?php echo $data['id_kelas'] ?>" class="btn btn-danger btn-sm">Hapus</a>
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
    let table = new DataTable('#kelas');
</script>