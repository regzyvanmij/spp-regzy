<?php
if (isset($_POST['spp'])) {
    $spp = $_POST['spp'];
}

if (isset($_POST['tambah'])) {
    $tahun = $_POST['tahun'];
    $nominal = $_POST['nominal'];
    $query = mysqli_query($koneksi, "INSERT INTO spp (tahun,nominal) VALUES('$tahun','$nominal')");
    if ($query) {
        echo '<script>alert("Data berhasil di Tambah");location.href="?page=spp";</script>';
    }
}

if (isset($_POST['edit'])) {
    $id_spp = $_POST['id_spp'];
    $tahun = $_POST['tahun'];
    $nominal = $_POST['nominal'];
    $query = mysqli_query($koneksi, "UPDATE spp SET  tahun='$tahun', nominal='$nominal' WHERE id_spp='$id_spp'");
    if ($query) {
        echo '<script>alert("Data berhasil di Update");location.href="?page=spp";</script>';
    }
}

if (isset($_POST['hapus'])) {
    $id_spp = $_POST['id_spp'];
    $query = mysqli_query($koneksi, "DELETE FROM spp WHERE id_spp='$id_spp'");
    if ($query) {
        echo '<script>alert("Data berhasil di Hapus");location.href="?page=spp";</script>';
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

<h1 class="h3 mb-3"><strong></strong>spp</h1>
<div class="row">
    <div class="col-12">
        <div class="card flex-fill">
            <div class="card-header">
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#tambahspp">
                    +tambah spp
                </button>
            </div>
            <div class="card-body">
                <table class=" table table-bordered table-striped table-hover cell-border" id="spp">
                    <thead>
                        <tr>
                            <th>tahun</th>
                            <th>nominal</th>
                            <th>action</th>
                    </thead>
                    <tbody>
                        <?php
                        $query = mysqli_query($koneksi, "SELECT * FROM spp");
                        while ($data = mysqli_fetch_array($query)) {
                        ?>
                            <tr>
                                <td><?php echo $data['tahun'] ?></td>
                                <td>Rp. <?php echo number_format($data['nominal'], 2, ',', '.') ?></td>
                                <td>
                                    <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editspp<?php echo $data['id_spp'] ?>">
                                        Edit
                                    </button>
                                    <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#hapusspp<?php echo $data['id_spp'] ?>">
                                        hapus
                                    </button>
                                </td>
                            </tr>
                            <div class="modal fade" id="editspp<?php echo $data['id_spp'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="staticBackdropLabel">edit spp</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form action="" method="post">
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <input type="hidden" name="id_spp" value="<?php echo $data['id_spp'] ?>">
                                                    <label class="form-label">tahun</label>
                                                    <input type="text" name="tahun" class="form-control" value="<?php echo $data['tahun'] ?>" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">nominal</label>
                                                    <input type="text" name="nominal" class="form-control" value="<?php echo $data['nominal'] ?>" required>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary" name="edit">simpan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="modal fade" id="hapusspp<?php echo $data['id_spp'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="staticBackdropLabel">hapus</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form action="" method="post">
                                            <div class="modal-body">
                                                <input type="hidden" name="id_spp" class="form-control" value="<?php echo $data['id_spp'] ?>">
                                                <div class="text-center">
                                                    <span>yakin ingin menghapus data?</span><br>
                                                    <div class="text-danger">
                                                        tahun - <?php echo $data['tahun'] ?><br>
                                                        nominal - <?php echo $data['nominal'] ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary" name="hapus">hapus</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
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
    let table = new DataTable('#spp');
</script>
<div class="modal fade" id="tambahspp" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">tambah spp</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="post">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">tahun</label>
                        <input type="text" name="tahun" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">nominal</label>
                        <input type="text" name="nominal" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" name="tambah">simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>