<?php
include 'koneksi.php';

// Ambil data siswa jika ID siswa tersedia
if(isset($_POST['id_siswa'])) {
    $id_siswa = $_POST['id_siswa'];
    $query = "SELECT siswa.*, angkatan.nama_angkatan, kelas.nama_kelas 
              FROM siswa 
              INNER JOIN angkatan ON siswa.id_angkatan = angkatan.id_angkatan 
              INNER JOIN kelas ON siswa.id_kelas = kelas.id_kelas 
              WHERE siswa.id_siswa = $id_siswa";
     $exec = mysqli_query($conn, $query);
     $res = mysqli_fetch_assoc($exec);
}
    ?>


    
    <form action="editdatasiswa.php" method="POST">
        <input type="hidden" name="id_siswa" value="<?= isset($res['id_siswa']) ? $res['id_siswa'] : '' ?>">
        <input type="text" class="form-control mb-2" name="nisn" value="<?= isset($res['nisn']) ? $res['nisn'] : '' ?>" placeholder="NISN">
        <input type="text" class="form-control mb-2" name="nama_siswa" value="<?= isset($res['nama_siswa']) ? $res['nama_siswa'] : '' ?>" placeholder="Nama Siswa">
    
        <select class="form-control mb-2" name="id_angkatan">
        <option selected>-Pilih Angkatan-</option>
        <?php
        $exec_angkatan = mysqli_query($conn, "SELECT * FROM angkatan ORDER BY id_angkatan");
        while ($angkatan = mysqli_fetch_assoc($exec_angkatan)) {
            $selected = (isset($res['id_angkatan']) && $res['id_angkatan'] == $angkatan['id_angkatan']) ? 'selected' : '';
            echo "<option $selected value='" . $angkatan['id_angkatan'] . "'>" . $angkatan['nama_angkatan'] . "</option>";
        }
        ?>
    </select>

    <select class="form-control mb-2" name="id_kelas">
        <option selected>-Pilih Kelas-</option>
        <?php
        $exec_kelas = mysqli_query($conn, "SELECT * FROM kelas ORDER BY id_kelas");
        while ($kelas = mysqli_fetch_assoc($exec_kelas)) {
            $selected = (isset($res['id_kelas']) && $res['id_kelas'] == $kelas['id_kelas']) ? 'selected' : '';
            echo "<option $selected value='" . $kelas['id_kelas'] . "'>" . $kelas['nama_kelas'] . "</option>";
        }
        ?>
    </select>

    <textarea class="form-control mb-2" name="alamat" placeholder="Alamat Siswa"><?= isset($res['alamat']) ? $res['alamat'] : '' ?></textarea>
    
    <!-- Tombol submit untuk edit data siswa -->
    <div class="modal-footer">
        <button type="button" class="btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" name="edit" class="btn btn-primary">Simpan</button>
    </div>
</form>

 <?php ?>
