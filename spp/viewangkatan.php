<?php
include 'funcion_rupiah.php';
include 'koneksi.php';


// Ambil data angkatan jika ID angkatan tersedia
if(isset($_POST['id_angkatan'])) {
    $id_angkatan=$_POST['id_angkatan'];
    $exec = mysqli_query($conn,"select * from angkatan where id_angkatan='$id_angkatan'");   
        $res = mysqli_fetch_assoc($exec);

        ?>
        <!-- Form untuk edit data angkatan -->
        <form action="editdataangkatan.php" method="POST">
            <input type="hidden" name="id_angkatan" value="<?= $res['id_angkatan'] ?>">
            <input type="text" name="nama_angkatan" class="form-control" value="<?= $res['nama_angkatan'] ?>">
            <input type="text" name="biaya" class="form-control" value="<?= $res['biaya'] ?>">
            <div class="modal-footer">
                <button type="button" class="btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" name="edit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    <?php }

?>