<?php
if (isset($_POST['tambah'])) {
    $nisn = $_POST['nisn'];
    $nis = $_POST['nis'];
    $nama = $_POST['nama'];
    $id_kelas = $_POST['id_kelas'];
    $alamat = $_POST['alamat'];
    $no_telp = $_POST['no_telp'];
    $password = md5($_POST['password']);
    $validasi = mysqli_query($koneksi, "SELECT * FROM siswa WHERE nisn='$nisn'");
    $validasi2 = mysqli_query($koneksi, "SELECT * FROM siswa WHERE nis='$nis'");

    if (mysqli_num_rows($validasi) > 0 && mysqli_num_rows($validasi2) > 0) {
        echo '<script>alert("nisn  dan nis telah terpakai");location.href="?page=siswa";</script>';
    } elseif (mysqli_num_rows($validasi) >  0) {
        echo '<script>alert("nisn   telah terpakai");location.href="?page=siswa";</script>';
    } elseif (mysqli_num_rows($validasi2) >  0) {
        echo '<script>alert("nis   telah terpakai");location.href="?page=siswa";</script>';
    } else {
        $query = mysqli_query($koneksi, "INSERT INTO siswa (nisn,nis,nama,id_kelas,alamat,no_telp,password) VALUES('$nisn','$nis','$nama','$id_kelas','$alamat','$no_telp','$password')");
        if ($query) {
            echo '<script>alert("Data berhasil di Tambah");location.href="?page=siswa";</script>';
        }
    }
}

if (isset($_POST['edit'])) {
    $oldnisn = $_POST['oldnisn'];
    $nisn = $_POST['nisn'];
    $nis = $_POST['nis'];
    $nama = $_POST['nama'];
    $id_kelas = $_POST['id_kelas'];
    $alamat = $_POST['alamat'];
    $no_telp = $_POST['no_telp'];
    $password = md5($_POST['password']);

    if (empty($_POST['password'])) {
        $query = mysqli_query($koneksi, "UPDATE siswa SET nisn='$nisn', nis='$nis', nama='$nama', id_kelas='$id_kelas', alamat='$alamat', no_telp='$no_telp' WHERE nisn='$oldnisn'");
        if ($query) {
            echo '<script>alert("Data berhasil di ubah");location.href="?page=siswa";</script>';
        }
    } else {
        $query = mysqli_query($koneksi, "UPDATE siswa SET nisn='$nisn', nis='$nis', nama='$nama', id_kelas='$id_kelas', alamat='$alamat', no_telp='$no_telp', password='$password' WHERE nisn='$oldnisn'");
        if ($query) {
            echo '<script>alert("Data berhasil di ubah");location.href="?page=siswa";</script>';
        }
    }
}

if (isset($_POST['hapus'])) {
    $oldnisn = $_POST['oldnisn'];
    $query = mysqli_query($koneksi, "DELETE FROM siswa WHERE nisn='$oldnisn'");
    if ($query) {
        echo '<script>alert("Data berhasil di hapus");location.href="?page=siswa";</script>';
    }
}

if (empty($_SESSION['petugas']['level'])) {
?>
    <script>
        alert('Akses di Tolak.');
        window.history.back();
    </script>
<?php
}
?>


<h1 class="h3 mb-3"><strong></strong>siswa</h1>
<div class="row">
    <div class="col-12">
        <div class="card flex-fill">

            <div class="card-body">
                <?php
                if (!empty($_SESSION['petugas']['level'] == 'admin')) {
                ?>
                    <button type="button" class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#tambahsiswa">
                        tambah siswa
                    </button>
                <?php
                }
                ?>
                <table class=" table table-bordered table-striped table-hover cell-border" id="siswa">
                    <thead>
                        <tr>
                            <th>NISN</th>
                            <th>NIS</th>
                            <th>Nama siswa</th>
                            <th>nama kelas</th>
                            <th>jurusan</th>
                            <th>alamat</th>
                            <th>no telp</th>
                            <th>action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (isset($_POST['siswa'])) {
                            $siswa = $_POST['siswa'];
                            $query = mysqli_query($koneksi, "SELECT * FROM siswa INNER JOIN kelas ON siswa.id_kelas=kelas.id_kelas WHERE nama_kelas= '$kelas' ");
                        } else {
                            $query = mysqli_query($koneksi, "SELECT * FROM siswa INNER JOIN kelas ON siswa.id_kelas=kelas.id_kelas  ");
                        }

                        $no = 1;
                        while ($data = mysqli_fetch_array($query)) {
                        ?>
                            <tr>
                                <td><?php echo $data['nisn'] ?></td>
                                <td><?php echo $data['nis'] ?></td>
                                <td><?php echo $data['nama'] ?></td>
                                <td><?php echo $data['nama_kelas'] ?></td>
                                <td><?php echo $data['kompetensi_keahlian'] ?></td>
                                <td><?php echo $data['alamat'] ?></td>
                                <td><?php echo $data['no_telp'] ?></td>
                                <td>
                                    <?php
                                    if (!empty($_SESSION['petugas']['level'] == 'admin')) {

                                    ?>
                                        <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editsiswa<?php echo $data['nisn'] ?>">
                                            Edit
                                        </button>
                                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#hapussiswa<?php echo $data['nisn'] ?>">
                                            hapus
                                        </button>
                                        <a href="?page=history&id=<?php echo $data['nisn'] ?>" class="btn btn-secondary btn-sm">history</a>
                                    <?php
                                    } else {
                                    ?>
                                        <a href="?page=history&id=<?php echo $data['nisn'] ?>" class="btn btn-secondary btn-sm">history</a>
                                    <?php
                                    }
                                    ?>
                                </td>
                            </tr>
                            <div class="modal fade" id="editsiswa<?php echo $data['nisn'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="staticBackdropLabel">edit</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form action="" method="post">
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <input type="hidden" name="oldnisn" class="form-control" value="<?php echo $data['nisn'] ?>">
                                                    <label class="form-label">Nisn</label>
                                                    <input type="text" name="nisn" class="form-control" value="<?php echo $data['nisn'] ?>" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">nis</label>
                                                    <input type="text" name="nis" class="form-control" value="<?php echo $data['nis'] ?>" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">nama siswa</label>
                                                    <input type="text" name="nama" class="form-control" value="<?php echo $data['nama'] ?>" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">kelas dan Jurusan</label>
                                                    <select name="id_kelas" class="form-select">
                                                        <?php
                                                        $query1 = mysqli_query($koneksi, "SELECT * FROM kelas");
                                                        while ($kelas = mysqli_fetch_array($query1)) {
                                                        ?>
                                                            <option value="<?php echo $kelas['id_kelas'] ?>"><?php echo $kelas['nama_kelas'] ?> - <?php echo $kelas['kompetensi_keahlian'] ?></option>
                                                        <?php

                                                        }
                                                        ?>
                                                    </select>

                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">alamat</label>
                                                    <input type="text" name="alamat" class="form-control" value="<?php echo $data['alamat'] ?>" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">no telp</label>
                                                    <input type="text" name="no_telp" class="form-control" value="<?php echo $data['no_telp'] ?>" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">password</label>
                                                    <input type="password" name="password" class="form-control">
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
                            <div class="modal fade" id="hapussiswa<?php echo $data['nisn'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="staticBackdropLabel">hapus</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form action="" method="post">
                                            <div class="modal-body">
                                                <input type="hidden" name="oldnisn" class="form-control" value="<?php echo $data['nisn'] ?>">
                                                <div class="text-center">
                                                    <span>yakin ingin menghapus data?</span><br>
                                                    <div class="text-danger">
                                                        nisn - <?php echo $data['nisn'] ?><br>
                                                        nama siswa - <?php echo $data['nama'] ?>
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

<div class="modal fade" id="tambahsiswa" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">tambah siswa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="post">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nisn</label>
                        <input type="text" name="nisn" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">nis</label>
                        <input type="text" name="nis" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">nama siswa</label>
                        <input type="text" name="nama" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">kelas dan Jurusan</label>
                        <select name="id_kelas" class="form-select">
                            <?php
                            $query1 = mysqli_query($koneksi, "SELECT * FROM kelas");
                            while ($data = mysqli_fetch_array($query1)) {
                            ?>
                                <option value="<?php echo $data['id_kelas'] ?>"><?php echo $data['nama_kelas'] ?> - <?php echo $data['kompetensi_keahlian'] ?></option>
                            <?php

                            }
                            ?>
                        </select>

                    </div>
                    <div class="mb-3">
                        <label class="form-label">alamat</label>
                        <input type="text" name="alamat" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">no telp</label>
                        <input type="text" name="no_telp" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">password</label>
                        <input type="password" name="password" class="form-control" required>
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

<script>
    let table = new DataTable('#siswa');
</script>