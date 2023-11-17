<?php
if (isset($_POST['edit'])) {
    $id_pembayaran = $_POST['id_pembayaran'];
    $kekurangan = $_POST['kekurangan'];
    $jumlah_bayar = $_POST['jumlah_bayar'];
    $oldjumlah_bayar = $_POST['oldjumlah_bayar'];

    $total = $oldjumlah_bayar + $jumlah_bayar;

    if ($jumlah_bayar > $kekurangan) {
        echo '<script>alert("jumlah bayar melebihi kekurangan");location.href="?page=laporan";</script>';
    } else {
        $query = mysqli_query($koneksi, "UPDATE pembayaran SET jumlah_bayar='$total' WHERE id_pembayaran='$id_pembayaran'");
        if ($query) {
            echo '<script>alert("Pembayaran Berhasil!");location.href="?page=laporan";</script>';
        }
    }
}
?>

<?php
if (empty($_SESSION['petugas']['level'])) {
?>
    <script>
        alert('Akses di Tolak.');
        window.history.back();
    </script>
<?php
}
?>


<h1 class="h3 mb-3"><strong></strong>laporan</h1>
<div class="row">
    <div class="col-12">
        <div class="card flex-fill">

            <div class="card-body">
                <?php
                if (!empty($_SESSION['petugas']['level'] == 'admin')) {
                ?>
                    <a href="cetak_pembayaran.php" target="_blank" class="btn btn-success btn-sm mb-3"><i data-feather="printer"></i>Print</a>

                <?php
                }
                ?>
                <table class=" table table-bordered table-striped table-hover cell-border" id="pembayaran">
                    <thead>
                        <tr>
                            <th>Nama petugas</th>
                            <th>Nama siswa</th>
                            <th>tanggal bayar</th>
                            <th>spp</th>
                            <th>jumlah bayar</th>
                            <th>status</th>
                            <th>action</th>
                        </tr>
                        <div class="container" style="text-align: center;">
                    </thead>
                    <tbody>
                        <?php
                        $query = mysqli_query($koneksi, "SELECT * FROM pembayaran INNER JOIN petugas ON pembayaran.id_petugas=petugas.id_petugas INNER JOIN siswa ON pembayaran.nisn=siswa.nisn INNER JOIN spp ON pembayaran.id_spp=spp.id_spp ");
                        while ($data = mysqli_fetch_array($query)) {
                        ?>
                            <tr>
                                <td><?php echo $data['nama_petugas'] ?></td>
                                <td><?php echo $data['nama'] ?></td>
                                <td><?php echo date('d-m-Y', strtotime($data['tgl_bayar'])) ?></td>
                                <td><?php echo $data['tahun'] ?> - Rp. <?php echo number_format($data['nominal'], 2, ',', '.') ?></td>
                                <td>Rp. <?php echo number_format($data['jumlah_bayar'], 2, ',', '.') ?></td>
                                <td>
                                    <?php
                                    if ($data['jumlah_bayar'] < $data['nominal']) {
                                        echo 'kurang';
                                    } else {
                                        echo 'lunas';
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    if ($data['nominal'] == $data['jumlah_bayar']) {
                                    ?>
                                        <button type="button" class="btn btn-success btn-sm">
                                            Lunas
                                        </button>
                                    <?php
                                    } else {
                                    ?>
                                        <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editpembayaran<?php echo $data['id_pembayaran'] ?>">
                                            Lunasi
                                        </button>
                                    <?php
                                    }
                                    ?>
                                </td>
                            </tr>
                            <div class="modal fade" id="editpembayaran<?php echo $data['id_pembayaran'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="staticBackdropLabel">lunasi</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form action="" method="post">
                                            <div class="modal-body">
                                                <input type="hidden" name="id_pembayaran" class="form-control" value="<?php echo $data['id_pembayaran'] ?>">
                                                <div class="mb-3">
                                                    <label class="form-label">Nama</label>
                                                    <input type="text" name="nama" class="form-control" value="<?php echo $data['nama'] ?>" disabled>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">tgl_bayar</label>
                                                    <input type="date" name="tanggal_bayar" class="form-control" value="<?php echo $data['tgl_bayar'] ?>" disabled>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">spp</label>
                                                    <input type="" name="id_spp" class="form-control" value=" <?php echo $data['tahun'] ?>- Rp. <?php echo number_format($data['nominal'], 2, ',', '.') ?>" disabled>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">kekurangan</label>
                                                    <input type="text" name="kekurangan" class="form-control" value="<?php echo $data['nominal'] - $data['jumlah_bayar'] ?>" readonly>
                                                </div>
                                                <div class="mb-3">
                                                    <input type="hidden" name="oldjumlah_bayar" class="form-control" value="<?php echo $data['jumlah_bayar'] ?>">
                                                    <label class="form-label">jumlah bayar</label>
                                                    <input type="text" name="jumlah_bayar" class="form-control">
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary" name="edit">simpan</button>
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
    let table = new DataTable('#pembayaran');
</script>