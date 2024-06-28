<?php
include 'koneksi.php'; // Include file koneksi.php untuk menghubungkan ke database
include 'header.php'; // Include file header.php untuk menampilkan header pada halaman
include 'funcion_rupiah.php';
// Form untuk melakukan pencarian siswa berdasarkan NISN
?>
<div class="card shadow mb-4">
    <div class="card-body">
        <form action="" method="get">
            <table class="table">
                <tr>
                    <td>NISN</td>
                    <td>:</td>
                    <td><input type="text" name="nisn" placeholder="Masukan NISN Siswa" class="form-control"></td>
                    <td><button type="submit" class="btn btn-primary" name="cari">Search</button></td>
                </tr>
            </table>
        </form>
    </div>
</div>

<?php
// Memeriksa apakah parameter NISN sudah diberikan dan tidak kosong
if (isset($_GET['nisn']) && $_GET['nisn'] != '') {
    $nisn = $_GET['nisn'];
    $query = "SELECT siswa.*, angkatan.*, kelas.* FROM siswa, angkatan, kelas WHERE siswa.id_angkatan = angkatan.id_angkatan AND siswa.id_kelas = kelas.id_kelas AND siswa.nisn = '$nisn'";
    $exec = mysqli_query($conn, $query);

    // Jika data siswa ditemukan
    if(mysqli_num_rows($exec) !==0){
        $siswa = mysqli_fetch_assoc($exec);
        $id_siswa = $siswa['id_siswa'];
?>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Biodata Siswa</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <tr>
                            <td>NISN</td>
                            <td><?= $siswa['nisn'] ?></td>
                        </tr>
                        <tr>
                            <td>Nama Siswa</td>
                            <td><?= $siswa['nama_siswa'] ?></td>
                        </tr>
                        <tr>
                            <td>Kelas</td>
                            <td><?= $siswa['nama_kelas'] ?></td>
                        </tr>
                        <tr>
                            <td>Tahun Ajaran</td>
                            <td><?= $siswa['nama_angkatan'] ?></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Data Pembayaran</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>NO</th>
                                <th>Bulan</th>
                                <th>Jatuh Tempo</th>
                                <th>No Bayar</th>
                                <th>Tanggal Bayar</th>
                                <th>Jumlah</th>
                                <th>Keterangan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            $query = "SELECT * FROM pembayaran WHERE id_siswa = '$id_siswa' ORDER BY jatuhtempo ASC";
                            $exec = mysqli_query($conn, $query);
                            while ($res = mysqli_fetch_assoc($exec)) {
                            ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $res['bulan'] ?></td>
                                    <td><?= $res['jatuhtempo'] ?></td>
                                    <td><?= $res['nobayar'] ?></td>
                                    <td><?= $res['tglbayar'] ?></td>
                                    <td><?= format_rupiah($res['jumlah']) ?></td>
                                    <td><?= $res['ket'] ?></td>
                                    <td>
                                        <?php
                                        if ($res['nobayar'] == '') {
                                            // Link untuk melakukan pembayaran
                                            echo "<a class='btn btn-primary btn-sm' href='transaksi.php?nisn=$nisn&act=bayar&id=$res[idspp]'>Bayar</a>";
                                        } else {
                                            // Link untuk membatalkan pembayaran dan mencetak
                                            echo "<a class='btn btn-danger btn-sm' href='transaksi.php?nisn=$nisn&act=batal&id=$res[idspp]'>Batal</a>";
                                            echo "<a class='btn btn-success btn-sm' href='cetak.php?nisn=$nisn&act=cetak&id=$res[idspp]' target='_blank'>Cetak</a>";
                                        }
                                        ?>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <?php
    } else {
        // Jika data siswa tidak ditemukan
        ?>
        <div class="card shadow mb-4">
            <div class="card-body">
                <h5>Data Tidak Tersedia</h5>
            </div>
        </div>
    <?php
    }
}
?>

<?php include 'footer.php'; // Include file footer.php untuk menampilkan footer pada halaman ?>
