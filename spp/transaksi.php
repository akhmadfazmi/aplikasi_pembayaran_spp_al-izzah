<?php
session_start();
include 'koneksi.php';

// Pastikan hanya admin yang sah yang dapat mengakses halaman ini
if (!isset($_SESSION['admin']) || $_SESSION['admin'] == 0) {
    header('Location: login.php');
    exit;
}

if (isset($_GET['act'])) {
    $act = $_GET['act'];
    $idspp = mysqli_real_escape_string($conn, $_GET['id']);
    $nisn = mysqli_real_escape_string($conn, $_GET['nisn']);

    if ($act == 'bayar') {
        $tglbayar = date('Y-m-d');
        $nobayar = date('dmYHisis');
        $id_admin = $_SESSION['admin'];
        $ket = 'LUNAS';

        $update_query = "UPDATE pembayaran SET nobayar=?, tglbayar=?, ket=?, id_admin=? WHERE idspp=?";
        $stmt = mysqli_prepare($conn, $update_query);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "sssii", $nobayar, $tglbayar, $ket, $id_admin, $idspp);
            mysqli_stmt_execute($stmt);

            if (mysqli_stmt_affected_rows($stmt) > 0) {
                header('Location: pembayaran.php?nisn=' . $nisn);
                exit;
            } else {
                echo "<script>alert('Gagal melakukan pembayaran');</script>";
            }

            mysqli_stmt_close($stmt);
        } else {
            echo "<script>alert('Gagal melakukan pembayaran');</script>";
        }
    } else if ($act == 'batal') {
        $nobayar = NULL;
        $tglbayar = NULL;
        $ket = NULL;
        $id_admin = NULL;

        $update_query = "UPDATE pembayaran SET nobayar=?, tglbayar=?, ket=?, id_admin=? WHERE idspp=?";
        $stmt = mysqli_prepare($conn, $update_query);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "sssii", $nobayar, $tglbayar, $ket, $id_admin, $idspp);
            mysqli_stmt_execute($stmt);

            if (mysqli_stmt_affected_rows($stmt) > 0) {
                header('Location: pembayaran.php?nisn=' . $nisn);
                exit;
            } else {
                echo "<script>alert('Gagal membatalkan pembayaran');</script>";
            }

            mysqli_stmt_close($stmt);
        } else {
            echo "<script>alert('Gagal membatalkan pembayaran');</script>";
        }
    }
}
?>
