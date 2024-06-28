<?php include 'header.php';
include 'koneksi.php';

// Tangani pencarian jika form dikirim
if(isset($_POST['submit'])){
    $keyword = $_POST['keyword'];
    $query = "SELECT siswa.*, angkatan.nama_angkatan, kelas.nama_kelas
              FROM siswa
              INNER JOIN angkatan ON siswa.id_angkatan = angkatan.id_angkatan
              INNER JOIN kelas ON siswa.id_kelas = kelas.id_kelas
              WHERE siswa.nisn LIKE '%$keyword%' OR siswa.nama_siswa LIKE '%$keyword%'
              ORDER BY siswa.id_siswa";
} else {
    // Query default jika tidak ada pencarian
    $query = "SELECT siswa.*, angkatan.nama_angkatan, kelas.nama_kelas
              FROM siswa
              INNER JOIN angkatan ON siswa.id_angkatan = angkatan.id_angkatan
              INNER JOIN kelas ON siswa.id_kelas = kelas.id_kelas
              ORDER BY siswa.id_siswa";
}

$exec = mysqli_query($conn, $query);
?>

<!-- Tabel Data Siswa -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">DataTables Siswa</h6>
    </div>
    <div class="card-body">
       

        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>NISN</th>
                        <th>Nama Siswa</th>
                        <th>Angkatan</th>
                        <th>Kelas</th>
                        <th>Alamat</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($res = mysqli_fetch_assoc($exec)){ ?>
                    <tr>
                        <td><?= $res['nisn']?></td>
                        <td><?= $res['nama_siswa']?></td>
                        <td><?= $res['nama_angkatan']?></td>
                        <td><?= $res['nama_kelas']?></td>
                        <td><?= $res['alamat']?></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include 'footer.php';?>
