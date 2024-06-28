<?php 
include 'header.php';
include 'koneksi.php';

if(isset($_GET['id_kelas'])) {
    $id_kelas = $_GET['id_kelas'];

    // Hapus data pembayaran siswa yang terkait dengan kelas yang dihapus
    $exec_delete_pembayaran = mysqli_query($conn, "DELETE pembayaran FROM pembayaran 
                                                    INNER JOIN siswa ON pembayaran.id_siswa = siswa.id_siswa
                                                    WHERE siswa.id_kelas = '$id_kelas'");
    
    // Hapus seluruh siswa dengan kelas yang dihapus
    $exec_delete_siswa = mysqli_query($conn, "DELETE FROM siswa WHERE id_kelas='$id_kelas'");
    $exec = mysqli_query($conn, "DELETE FROM kelas WHERE id_kelas='$id_kelas'");
    if($exec) {
        echo "<script>alert('Data kelas berhasil dihapus');
        document.location='editdatakelas.php';</script>";
    } else {
        echo "<script>alert('Data kelas gagal dihapus');
        document.location='editdataskelas.php';</script>";
    }
}

if(isset($_POST['submit'])){
    $keyword = $_POST['keyword'];
    $query = "SELECT siswa.*, angkatan.nama_angkatan, kelas.nama_kelas
              FROM siswa
              INNER JOIN angkatan ON siswa.id_angkatan = angkatan.id_angkatan
              INNER JOIN kelas ON siswa.id_kelas = kelas.id_kelas
              WHERE kelas.nama_kelas LIKE '%$keyword%'
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
        <h6 class="m-0 font-weight-bold text-primary">Data kelas</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                       
                        <th>Nama Kelas</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                
                $query = "SELECT * FROM kelas ";
                $exec = mysqli_query($conn, $query);
                while ($res = mysqli_fetch_assoc($exec)) {
                ?>
                    <tr>
                        
                        <td><?= $res['nama_kelas'] ?></td>
                        <td>
                            <a href="editdatakelas.php?id_kelas=<?= $res['id_kelas'] ?>" 
                            class="btn btn-sm btn-danger" onclick="return confirm('Apakah Yakin Ingin Menghapus Data?')">hapus</a>
                            <a href="#" class="view_data btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#myModal" id="<?= $res['id_kelas']; ?>">Edit</a>
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
                <h5 class="modal-title" id="exampleModalLabel">Data Kelas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="POST">
                    <input type="text" name="nama_kelas" placeholder="Nama Kelas" class="form-control  mb-2">
                    
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
                <h5 class="modal-title" id="exampleModalLabel">Edit Data kelas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="close">x</button>
            </div>
         <div class="modal-body" id="datakelas">
    </div>
 </div>
</div> 
</div>

<?php
if (isset($_POST['simpan'])) {
    $nama_kelas = htmlentities(strip_tags(strtoupper($_POST['nama_kelas'])));
    $query = "INSERT INTO kelas (nama_kelas) 
              VALUES ('$nama_kelas')";
    $exec = mysqli_query($conn, $query);
    if ($exec) {
        echo "<script>alert('Data Kelas Berhasil Di Simpan');
        document.location= 'editdatakelas.php';
        </script>";
    } else {
        echo "<script>alert('Data Kelas Gagal Di Simpan');
        document.location= 'editdatakelas.php';
        </script>";
    }
}
?>

<?php include 'footer.php'; ?>

<script type="text/javascript">
    $(document).ready(function(){
        $('.view_data').click(function(){
            var id_kelas = $(this).attr('id');
            $.ajax({
                url: 'viewkelas.php',
                method: 'post',
                data: {id_kelas: id_kelas},
                success:function(data){
                    $('#datakelas').html(data);
                    $('#myModal').modal('show');
                }
            });
        });
    });
</script>

<?php
if(isset($_POST['edit'])) {
    $id_kelas = $_POST['id_kelas'];
    $nama_kelas = htmlentities(strip_tags(strtoupper($_POST['nama_kelas'])));
    $query = "UPDATE kelas SET nama_kelas='$nama_kelas' WHERE id_kelas='$id_kelas'";
    $exec = mysqli_query($conn, $query);
    if($exec) {
        echo "<script>alert('Data kelas berhasil di edit');
        document.location='editdatakelas.php'</script>";
    } else {
        echo "<script>alert('Data kelas gagal di edit');
        document.location='editdatakelas.php'</script>";
    }
}
?>
