<?php
include 'koneksi.php';
if (empty($_SESSION['petugas']['level'] == 'admin')) {
?>
    <script>
        alert('Akses di Tolak.');
        window.history.back();
    </script>
<?php
}
?>

<script>
    window.print();
</script>

<table border="1" width="100%" cellpadding="5" cellspacing="0">
    <tr>
        <th colspan="8">Cetak Pembayaran</th>
    </tr>
    <tr>
        <th>No</th>
        <th>Nama petugas</th>
        <th>Nama siswa</th>
        <th>Tanggal bayar</th>
        <th>SPP</th>
        <th>Jumlah bayar</th>
    </tr>
    </thead>
    <tbody>
        <?php
        $i = 1;
        $query = mysqli_query($koneksi, "SELECT * FROM pembayaran INNER JOIN petugas ON pembayaran.id_petugas=petugas.id_petugas INNER JOIN siswa ON pembayaran.nisn=siswa.nisn INNER JOIN spp ON pembayaran.id_spp=spp.id_spp");
        while ($data = mysqli_fetch_array($query)) {
        ?>
            <tr>
                <td><?php echo $i++ ?></td>
                <td><?php echo $data['nama_petugas'] ?></td>
                <td><?php echo $data['nama'] ?></td>
                <td><?php echo date('d-m-y', strtotime($data['tgl_bayar'])) ?></td>
                <td><?php echo $data['tahun'] ?> - Rp <?php echo number_format($data['nominal'], 2, ',', '.') ?></td>
                <td> Rp. <?php echo number_format($data['jumlah_bayar'], 2, ',', '.') ?></td>
            </tr>
        <?php
        }
        ?>
        </tr>
    </tbody>
</table>