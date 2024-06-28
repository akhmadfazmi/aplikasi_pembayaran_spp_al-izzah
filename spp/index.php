<?php 
include 'funcion_rupiah.php';
// Masukkan header.php
include 'header.php';

// Periksa apakah pengguna sudah login


// Masukkan koneksi.php
include 'koneksi.php';

// Ambil data pembayaran yang sudah lunas
$query = "SELECT * FROM pembayaran WHERE ket = 'LUNAS'";
$exec = mysqli_query($conn, $query);

if (!$exec) {
    // Jika query gagal, tampilkan pesan error
    echo "Error: " . mysqli_error($conn);
    exit;
}

$totalspp = mysqli_num_rows($exec);
$totaltrx = 0;
while ($res = mysqli_fetch_assoc($exec)) {
    $totaltrx += $res['jumlah'];
}

?>

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
</div>

<!-- Content Row -->
<div class="row">
    <!-- Total Pembayaran Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Pembayaran</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $totalspp ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-calendar fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Uang Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Uang</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">Rp.<?= format_rupiah($totaltrx) ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Content Row -->
<?php include 'footer.php'; ?>
