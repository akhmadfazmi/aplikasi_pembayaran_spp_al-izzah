<?php include 'header.php';
include 'koneksi.php'; ?>
<div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Cetak Laporan</h6>
                        </div>
                        <div class="card-body">
                        <form action="cetak_laporan.php" method="get" target="_blank">
                            <input type="date" name="awal" class="form_control mb-2">
                            <input type="date" name="akhir" class="form_control mb-2">
                            <button type="submit" class="btn btn-primary" name="cetak">Cetak</button>
                        </form>
</div>
</div>


<?php include 'footer.php';?>