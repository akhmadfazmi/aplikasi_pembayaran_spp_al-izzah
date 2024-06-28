<?php 
include 'funcion_rupiah.php';
include 'header.php';
include 'koneksi.php';

if(isset($_GET['id_angkatan'])) {
    $id_angkatan = $_GET['id_angkatan'];
    
    // Hapus data pembayaran siswa yang terkait dengan angkatan yang dihapus
    $exec_delete_pembayaran = mysqli_query($conn, "DELETE pembayaran FROM pembayaran 
                                                    INNER JOIN siswa ON pembayaran.id_siswa = siswa.id_siswa
                                                    WHERE siswa.id_angkatan = '$id_angkatan'");
    
    // Hapus seluruh siswa dengan angkatan yang dihapus
    $exec_delete_siswa = mysqli_query($conn, "DELETE FROM siswa WHERE id_angkatan='$id_angkatan'");
    
    // Hapus data angkatan
    $exec = mysqli_query($conn, "DELETE FROM angkatan WHERE id_angkatan='$id_angkatan'");
    
    if($exec && $exec_delete_siswa && $exec_delete_pembayaran) {
        echo "<script>alert('Data angkatan, siswa, dan pembayaran berhasil dihapus');
        document.location='editdataangkatan.php';</script>";
    } else {
        echo "<script>alert('Data angkatan, siswa, dan pembayaran gagal dihapus');
        document.location='editdataangkatan.php';</script>";
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
        <h6 class="m-0 font-weight-bold text-primary">Data angkatan</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        
                        <th>Nama Angkatan</th>
                        <th>Biaya</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                
                $query = "SELECT * FROM angkatan ";
                $exec = mysqli_query($conn, $query);
                while ($res = mysqli_fetch_assoc($exec)) {
                ?>
                    <tr>
                        
                        <td><?= $res['nama_angkatan'] ?></td>
                        <td><?= format_rupiah($res['biaya']) ?></td>
                        <td>
                            <a href="editdataangkatan.php?id_angkatan=<?= $res['id_angkatan'] ?>" 
                            class="btn btn-sm btn-danger" onclick="return confirm('Apakah Yakin Ingin Menghapus Data?')">hapus</a>
                            <a href="#" class="view_data btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#myModal" id="<?= $res['id_angkatan']; ?>">Edit</a>
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

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Data Angkatan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="POST">
                    <input type="text" name="nama_angkatan" placeholder="Nama Angkatan" class="form-control  mb-2">
                    <input type="text" name="biaya" placeholder="Biaya SPP" class="form-control  mb-2">
                    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="Submit" name="simpan" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Data Angkatan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="close">x</button>
            </div>
         <div class="modal-body" id="dataangkatan">
    </div>
 </div>
</div> 
</div>

<?php
if (isset($_POST['simpan'])) {
    $nama_angkatan = htmlentities(strip_tags(strtoupper($_POST['nama_angkatan'])));
    $biaya = htmlentities(strip_tags(strtoupper($_POST['biaya'])));
    if (empty($nama_angkatan) || empty($biaya)) {
        echo "<script>alert('Semua bidang harus diisi!');</script>";
    } else {
    $query = "INSERT INTO angkatan (nama_angkatan,biaya) 
              VALUES ('$nama_angkatan','$biaya')";
    $exec = mysqli_query($conn, $query);
    if ($exec) {
        echo "<script>alert('Data angkatan Berhasil Di Simpan');
        document.location= 'editdataangkatan.php';
        </script>";
    } else {
        echo "<script>alert('Data angkatan Gagal Di Simpan');
        document.location= 'editdataangkatan.php';
        </script>";
    }
}
}
?>

<?php include 'footer.php'; ?>

<script type="text/javascript">
    $(document).ready(function(){
        $('.view_data').click(function(){
            var id_angkatan = $(this).attr('id');
            $.ajax({
                url: 'viewangkatan.php',
                method: 'post',
                data: {id_angkatan: id_angkatan},
                success:function(data){
                    $('#dataangkatan').html(data);
                    $('#myModal').modal('show');
                }
            });
        });
    });
</script>

<?php
if(isset($_POST['edit'])) {
    $id_angkatan = $_POST['id_angkatan'];
    $nama_angkatan = htmlentities(strip_tags(strtoupper($_POST['nama_angkatan'])));
    $biaya = htmlentities(strip_tags(strtoupper($_POST['biaya'])));
    if (empty($nama_angkatan) || empty($biaya)) {
        echo "<script>alert('Semua bidang harus diisi!');</script>";
    } else {
    $query = "UPDATE angkatan SET nama_angkatan='$nama_angkatan', biaya='$biaya' WHERE id_angkatan='$id_angkatan'";
    $exec = mysqli_query($conn, $query);
    if($exec) {
        echo "<script>alert('Data angkatan berhasil di edit');
        document.location='editdataangkatan.php'</script>";
    } else {
        echo "<script>alert('Data angkatan gagal di edit');
        document.location='editdataangkatan.php'</script>";
    }
}
}
?>