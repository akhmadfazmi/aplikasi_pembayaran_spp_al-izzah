<?php
include 'koneksi.php';


// Ambil data kelas jika ID kelas tersedia
if(isset($_POST['id_kelas'])) {
    $id_kelas=$_POST['id_kelas'];
    $exec = mysqli_query($conn,"select * from kelas where id_kelas='$id_kelas'");   
        $res = mysqli_fetch_assoc($exec);

        ?>
        <!-- Form untuk edit data kelas -->
        <form action="editdatakelas.php" method="POST">
            <input type="hidden" name="id_kelas" value="<?= $res['id_kelas'] ?>">
            <input type="text" name="nama_kelas" class="form-control" value="<?= $res['nama_kelas'] ?>">
            <div class="modal-footer">
                <button type="button" class="btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" name="edit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    <?php }

?>