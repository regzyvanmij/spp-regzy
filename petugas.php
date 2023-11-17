<?php
if (isset($_POST['tambah'])) {
    $username = $_POST['username'];
    $nama = $_POST['nama'];
    $password = md5($_POST['password']);
    $level = $_POST['level'];
    $query = mysqli_query($koneksi, "INSERT INTO petugas (username,nama_petugas,password,level) VALUES('$username','$nama','$password','$level')");
    if ($query) {
        echo '<script>alert("Data berhasil di Tambah");location.href="?page=petugas";</script>';
    }
}

if (isset($_POST['edit'])) {
    $id_petugas = $_POST['id_petugas'];
    $username = $_POST['username'];
    $nama_petugas = $_POST['nama_petugas'];
    $password = md5($_POST['password']);
    $level = $_POST['level'];

    if ($_POST['password'] == '') {
        $query = mysqli_query($koneksi, "UPDATE petugas SET nama_petugas = '$nama_petugas', username = '$username', level = '$level' WHERE id_petugas = $id_petugas");
        if ($query) {
            echo '<script>alert("Data Berhasil di Update");location.href="?page=petugas";</script>';
        }
    } else {
        $query = mysqli_query($koneksi, "UPDATE petugas SET nama_petugas = '$nama_petugas', password='$password' , username = '$username', level = '$level' WHERE id_petugas = $id_petugas");
        if ($query) {
            echo '<script>alert("Data Berhasil di Update");location.href="?page=petugas";</script>';
        }
    }
}


if (isset($_POST['hapus'])) {
    $id_petugas = $_POST['id_petugas'];
    $query = mysqli_query($koneksi, "DELETE FROM petugas WHERE id_petugas='$id_petugas'");
    if ($query) {
        echo '<script>alert("Data berhasil di hapus");location.href="?page=petugas";</script>';
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

<h1 class="h3 mb-3"><strong></strong>petugas</h1>
<div class="row">
    <div class="col-12">
        <div class="card flex-fill">
            <div class="card-header">
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#tambahpetugas">
                    +tambah petugas
                </button>
            </div>
            <div class="card-body">
                <table class=" table table-bordered table-striped table-hover cell-border" id="petugas">
                    <thead>
                        <tr>
                            <th>no</th>
                            <th>username</th>
                            <th>Nama petugas</th>
                            <th>level</th>
                            <th>action</th>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        $query = mysqli_query($koneksi, "SELECT * FROM petugas");
                        while ($data = mysqli_fetch_array($query)) {
                        ?>
                            <tr>
                                <td><?php echo $no ?></td>
                                <td><?php echo $data['username'] ?></td>
                                <td><?php echo $data['nama_petugas'] ?></td>
                                <td><?php echo $data['level'] ?></td>
                                <td>
                                    <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editpetugas<?php echo $data['id_petugas'] ?>">
                                        Edit
                                    </button>
                                    <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#hapuspetugas<?php echo $data['id_petugas'] ?>">
                                        hapus
                                    </button>
                                </td>
                            </tr>
                            <div class="modal fade" id="editpetugas<?php echo $data['id_petugas'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="staticBackdropLabel">edit petugas</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form action="" method="post">
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <input type="hidden" name="id_petugas" class="form-control" value="<?php echo $data['id_petugas'] ?>">
                                                    <label class="form-label">username</label>
                                                    <input type="text" name="username" class="form-control" value="<?php echo $data['username'] ?>" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">nama petugas</label>
                                                    <input type="text" name="nama_petugas" class="form-control" value="<?php echo $data['nama_petugas'] ?>" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">password</label>
                                                    <input type="password" name="password" class="form-control">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">level</label>
                                                    <select name="level" class="form-select">
                                                        <option value="admin" <?php echo ($data['level'] == 'admin' ? 'selected' : '') ?>>Admin</option>
                                                        <option value="petugas" <?php echo ($data['level'] == 'petugas' ? 'selected' : '') ?>>Petugas</option>
                                                    </select>
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
                            <div class="modal fade" id="hapuspetugas<?php echo $data['id_petugas'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="staticBackdropLabel">hapus</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form action="" method="post">
                                            <div class="modal-body">
                                                <input type="hidden" name="id_petugas" class="form-control" value="<?php echo $data['id_petugas'] ?>">
                                                <div class="text-center">
                                                    <span>yakin ingin menghapus data?</span><br>
                                                    <div class="text-danger">
                                                        username - <?php echo $data['username'] ?><br>
                                                        nama petugas - <?php echo $data['nama_petugas'] ?>
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
                            $no++;
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    let table = new DataTable('#petugas');
</script>
<div class="modal fade" id="tambahpetugas" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">tambah petugas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="post">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">username</label>
                        <input type="text" name="username" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">nama petugas</label>
                        <input type="text" name="nama" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">level</label>
                        <select name="level" class="form-select">
                            <option value="admin">Admin</option>
                            <option value="petugas">Petugas</option>
                        </select>
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