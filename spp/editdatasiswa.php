<?php 
include 'header.php';
include 'koneksi.php';

if(isset($_GET['id_siswa'])) {
    $id_siswa = $_GET['id_siswa'];

    // Delete student data
    $exec_student = mysqli_query($conn, "DELETE FROM siswa WHERE id_siswa='$id_siswa'");
    // Delete payment data associated with the student
    $exec_payment = mysqli_query($conn, "DELETE FROM pembayaran WHERE id_siswa='$id_siswa'");

    if($exec_student && $exec_payment) {
        echo "<script>alert('Data siswa dan pembayaran berhasil dihapus')
        document.location='editdatasiswa.php'</script>";
    } else {
        echo "<script>alert('Gagal menghapus data siswa atau pembayaran')
        document.location='editdatasiswa.php'</script>";
    }
}

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

<!-- button trigger -->
<button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#exampleModal">Tambah Data</button>

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Data Tables Siswa</h6>
    </div>
    <div class="card-body">
        
        <!-- Tabel Data Siswa -->
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>NISN</th>
                        <th>Nama Siswa</th>
                        <th>Angkatan</th>
                        <th>Kelas</th>
                        <th>Alamat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($res = mysqli_fetch_assoc($exec)) : ?>
                        <tr>
                            <td><?= $res['nisn'] ?></td>
                            <td><?= $res['nama_siswa'] ?></td>
                            <td><?= $res['nama_angkatan'] ?></td>
                            <td><?= $res['nama_kelas'] ?></td>
                            <td><?= $res['alamat'] ?></td>
                            <td>
                                <a href="editdatasiswa.php?id_siswa=<?= $res['id_siswa'] ?>" 
                                class="btn btn-sm btn-danger" onclick="return confirm('Apakah Yakin Ingin Menghapus Data?')">hapus</a>
                                <a href="#" class="view_data btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#myModal" data-id="<?php echo $res['id_siswa']; ?>">Edit</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Data Siswa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="POST" id="form_siswa">
                    <input type="text" name="nisn" placeholder="NISN" class="form-control mb-2">
                    <input type="text" name="nama_siswa" placeholder="Nama Siswa" class="form-control mb-2">
                    <select class="form-control mb-2" name="id_angkatan" id="id_angkatan">
                        <option value="">-Pilih Angkatan-</option>
                        <?php
                        $exec = mysqli_query($conn, "SELECT * FROM angkatan ORDER BY id_angkatan");
                        while ($angkatan = mysqli_fetch_assoc($exec)) {
                            echo "<option value=" . $angkatan['id_angkatan'] . ">" . $angkatan['nama_angkatan'] . "</option>";
                        }
                        ?>
                    </select>
                    <select class="form-control mb-2" name="id_kelas" id="id_kelas">
                        <option value="">-Pilih Kelas-</option>
                        <?php
                        $exec = mysqli_query($conn, "SELECT * FROM kelas ORDER BY id_kelas");
                        while ($kelas = mysqli_fetch_assoc($exec)) {
                            echo "<option value=" . $kelas['id_kelas'] . ">" . $kelas['nama_kelas'] . "</option>";
                        }
                        ?>
                    </select>
                    <textarea class="form-control mb-2" name="alamat" placeholder="Alamat"></textarea>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="Submit" name="simpan" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
            <script type="text/javascript">
                document.addEventListener('DOMContentLoaded', function () {
                    document.querySelector('form').addEventListener('submit', function (event) {
                        var nisn = document.getElementsByName('nisn')[0].value;
                        var nama_siswa = document.getElementsByName('nama_siswa')[0].value;
                        var id_angkatan = document.getElementsByName('id_angkatan')[0].value;
                        var id_kelas = document.getElementsByName('id_kelas')[0].value;
                        var alamat = document.getElementsByName('alamat')[0].value;

                        if (!nisn || !nama_siswa || !id_angkatan || !id_kelas || !alamat) {
                            alert('Semua bidang harus diisi!');
                            event.preventDefault();
                        }
                    });
                });
            </script>
        </div>
    </div>
</div>

<div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Data Siswa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="close">x</button>
            </div>
            <div class="modal-body" id="datasiswa"></div>
        </div>
    </div> 
</div>

<?php
if (isset($_POST['simpan'])) {
    $nisn = htmlentities(strip_tags($_POST['nisn']));
    $nama_siswa = htmlentities(strip_tags(ucwords($_POST['nama_siswa'])));
    $id_kelas = htmlentities(strip_tags($_POST['id_kelas']));
    $id_angkatan = htmlentities(strip_tags($_POST['id_angkatan']));
    $alamat = htmlentities(strip_tags(ucwords($_POST['alamat'])));

    if (!$nisn || !$nama_siswa || !$id_kelas || !$id_angkatan || !$alamat) {
        echo "<script>alert('Semua bidang harus diisi!'); 
        document.location='editdatasiswa.php'</script>";
    } else {
        // Check if NISN already exists
        $query_check = "SELECT * FROM siswa WHERE nisn='$nisn'";
        $exec_check = mysqli_query($conn, $query_check);
        if (mysqli_num_rows($exec_check) > 0) {
            echo "<script>alert('NISN sudah ada, harap masukkan NISN yang berbeda');
            document.location='editdatasiswa.php'</script>";
        } else {
            $query = "INSERT INTO siswa (nisn, nama_siswa, id_angkatan, id_kelas, alamat) 
                      VALUES ('$nisn', '$nama_siswa', '$id_angkatan', '$id_kelas', '$alamat')";
            $exec = mysqli_query($conn, $query);
            if ($exec) {
                $bulanIndo = [
                    '01' => 'Januari',
                    '02' => 'Februari',
                    '03' => 'Maret',
                    '04' => 'April',
                    '05' => 'Mei',
                    '06' => 'Juni',
                    '07' => 'Juli',
                    '08' => 'Agustus',
                    '09' => 'September',
                    '10' => 'Oktober',
                    '11' => 'November',
                    '12' => 'Desember'
                ];
                
                $query = "SELECT siswa.*, angkatan.* FROM siswa, angkatan WHERE siswa.id_angkatan = angkatan.id_angkatan ORDER BY siswa.id_siswa DESC LIMIT 1";
                $exec = mysqli_query($conn, $query);
                $res = mysqli_fetch_assoc($exec);
                $biaya = $res['biaya'];
                $id_siswa = $res['id_siswa'];
                $awaltempo = date('Y-m-d');
    
                for ($i = 0; $i < 12; $i++) {
                    // Menghitung bulan jatuh tempo mulai dari bulan Juli (bulan ke-7)
                    $jatuhtempo = date("Y-m-d", strtotime("+$i month", strtotime(date('Y') . '-07-10')));
                    $bulan = $bulanIndo[date('m', strtotime($jatuhtempo))] . " " . date('Y', strtotime($jatuhtempo));
                    
                    // Simpan data pembayaran
                    $add = mysqli_query($conn, "INSERT INTO pembayaran (id_siswa, jatuhtempo, bulan, jumlah) VALUES ('$id_siswa', '$jatuhtempo', '$bulan', '$biaya')");
                }
            
                echo "<script>alert('Berhasil Disimpan'); 
                document.location='editdatasiswa.php'</script>";
            } else {
                echo "<script>alert('Gagal Menyimpan'); 
                document.location='editdatasiswa.php'</script>";
            }
        }
    }
}
?>

<?php include 'footer.php';?>
<script type="text/javascript">
    $(document).ready(function(){
        $('.view_data').click(function(){
            var id_siswa = $(this).attr('data-id');
            $.ajax({
                url: 'view.php',
                method: 'post',
                data: {id_siswa: id_siswa},
                success:function(data){
                    $('#datasiswa').html(data);
                    $('#myModal').modal('show');
                }
            });
        });
    });
</script>

<?php
if(isset($_POST['edit'])) {
    $id_siswa = $_POST['id_siswa'];
    $nisn = htmlentities(strip_tags(ucwords($_POST['nisn'])));
    $nama_siswa = htmlentities(strip_tags(ucwords($_POST['nama_siswa'])));
    $id_kelas = htmlentities(strip_tags($_POST['id_kelas']));
    $id_angkatan = htmlentities(strip_tags($_POST['id_angkatan']));
    $alamat = htmlentities(strip_tags(ucwords($_POST['alamat'])));

    $query = "UPDATE siswa SET nisn='$nisn',
                                nama_siswa='$nama_siswa',
                                id_angkatan='$id_angkatan',
                                id_kelas='$id_kelas',
                                alamat='$alamat' WHERE id_siswa='$id_siswa'";
    $exec = mysqli_query($conn, $query);
    if($exec) {
        // Get last payment data
        $query_last_payment = "SELECT * FROM pembayaran WHERE id_siswa='$id_siswa' ORDER BY jatuhtempo DESC LIMIT 1";
        $exec_last_payment = mysqli_query($conn, $query_last_payment);
        $last_payment = mysqli_fetch_assoc($exec_last_payment);
        
        // Calculate next due date for a year ahead
        $next_due_date = $last_payment['jatuhtempo'];
        $bulanIndo = [
            '01' => 'Januari',
            '02' => 'Februari',
            '03' => 'Maret',
            '04' => 'April',
            '05' => 'Mei',
            '06' => 'Juni',
            '07' => 'Juli',
            '08' => 'Agustus',
            '09' => 'September',
            '10' => 'Oktober',
            '11' => 'November',
            '12' => 'Desember'
        ];
        
        // Loop for a year ahead
        for ($i = 0; $i < 12; $i++) {
            $next_due_date = date('Y-m-d', strtotime('+1 month', strtotime($next_due_date)));
            $bulan = $bulanIndo[date('m', strtotime($next_due_date))] . " " . date('Y', strtotime($next_due_date));
            
            // Insert new payment data for each month
            $query_insert_payment = "INSERT INTO pembayaran (id_siswa, jatuhtempo, bulan, jumlah) 
                                     VALUES ('$id_siswa', '$next_due_date', '$bulan', '$last_payment[jumlah]')";
            $exec_insert_payment = mysqli_query($conn, $query_insert_payment);
            
            if(!$exec_insert_payment) {
                echo "<script>alert('Data pembayaran siswa gagal ditambahkan')
                document.location='editdatasiswa.php'</script>";
                exit; // Exit loop if insertion fails
            }
        }

        echo "<script>alert('Data siswa berhasil di edit')
        document.location='editdatasiswa.php'</script>";
    } else {
        echo "<script>alert('Data siswa gagal di edit')
        document.location='editdatasiswa.php'</script>";
    }
}
?>