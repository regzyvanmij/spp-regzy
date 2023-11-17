<h1 class="h3 mb-3"><strong></strong>history</h1>
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

<div class="row">
    <div class="col-12">
        <div class="card flex-fill">
            <div class="card-body">
                <?php
                if (!empty($_SESSION['petugas']['level'] == 'admin')) {
                ?>
                    <a href="cetak_history.php?id=<?php echo $_GET['id'] ?>" target="_blank" class="btn btn-success btn-sm mb-3"><i data-feather="printer"></i>Print</a>
                <?php
                }
                ?>
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
                        if (isset($_GET['id'])) {
                            $id = $_GET['id'];
                            $query = mysqli_query($koneksi, "SELECT * FROM pembayaran INNER JOIN petugas ON pembayaran.id_petugas=petugas.id_petugas INNER JOIN siswa ON pembayaran.nisn=siswa.nisn INNER JOIN spp ON pembayaran.id_spp=spp.id_spp where pembayaran.nisn='$id' ");
                        }
                        while ($data = mysqli_fetch_array($query)) {
                        ?>
                            <tr>
                                <td><?php echo $data['nama_petugas'] ?></td>
                                <td><?php echo $data['nama'] ?></td>
                                <td><?php echo date('d-m-y', strtotime($data['tgl_bayar'])) ?></td>
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